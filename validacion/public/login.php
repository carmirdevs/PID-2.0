<?php
require dirname(__DIR__).'/app/bootstrap.php';
$error='';
$loginKey=rateKey('login', (string)($_SERVER['REMOTE_ADDR']??'unknown'));
if (rateBlocked($loginKey)){http_response_code(429);header('Retry-After: 900');exit('Demasiados intentos. Vuelva a intentarlo más tarde.');}
if($_SERVER['REQUEST_METHOD']==='POST'){
 checkcsrf();
 $s=$pdo->prepare('SELECT * FROM survey_admins WHERE username=?');$s->execute([$_POST['username']??'']);$u=$s->fetch();
 if($u&&password_verify((string)($_POST['password']??''),$u['password_hash'])){
 rateClear($loginKey);session_regenerate_id(true);$_SESSION['staff_role']=$u['role'];$_SESSION['staff_id']=$u['id'];header('Location: '.($u['role']==='admin'?'admin.php':'results.php'));exit;
 }rateFail($loginKey);$error='Credenciales incorrectas';
}
page('Acceso administrativo / revisor');
if($error)echo '<div class="alert alert-danger">'.h($error).'</div>';
echo '<form method="post"><input type="hidden" name="csrf" value="'.h(csrf()).'"><label>Usuario<input class="form-control" name="username" required></label><br><label>Contraseña<input class="form-control" name="password" type="password" required></label><br><button class="btn btn-primary">Entrar</button></form>';endpage();
