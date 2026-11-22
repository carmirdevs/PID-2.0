<?php
if(PHP_SAPI!=='cli'){exit('Solo CLI');}
require dirname(__DIR__).'/app/bootstrap.php';
if($argc!==4||!in_array($argv[2],['admin','reviewer'],true)){exit("Uso: php create_user.php usuario admin|reviewer CONTRASENA\n");}
if(strlen($argv[3])<14){exit("Contraseña mínima de 14 caracteres\n");}
$s=$pdo->prepare('INSERT INTO survey_admins(username,password_hash,role) VALUES(?,?,?)');
$s->execute([$argv[1],password_hash($argv[3],PASSWORD_DEFAULT),$argv[2]]);
echo "Usuario creado\n";
