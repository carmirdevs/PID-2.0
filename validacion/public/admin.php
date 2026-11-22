<?php
require dirname(__DIR__).'/app/bootstrap.php';requireRole(['admin']);
$messages=[];$links=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
 checkcsrf();
 if(!isset($_FILES['csv'])||$_FILES['csv']['error']!==UPLOAD_ERR_OK||$_FILES['csv']['size']>1024*1024){exit('CSV inválido o mayor de 1 MB');}
 $f=fopen($_FILES['csv']['tmp_name'],'rb');$header=fgetcsv($f);if($header) $header[0]=preg_replace('/^\xEF\xBB\xBF/','',$header[0]);
 if($header!==['nombre','correo','area']){exit('Encabezado requerido: nombre,correo,area');}
 $count=0;$skip=0;
 while(($row=fgetcsv($f))!==false){
  if(count($row)!==3){$skip++;continue;}
  [$name,$email,$role]=array_map('trim',$row);
  if(strlen($name)>180||!filter_var($email,FILTER_VALIDATE_EMAIL)||!in_array($role,['docente','coordinacion','jefatura'],true)){$skip++;continue;}
  $token=bin2hex(random_bytes(32));$hash=hash('sha256',$token);
  $s=$pdo->prepare('INSERT IGNORE INTO survey_invites(full_name,email,role,token_hash,expires_at) VALUES(?,?,?,?,DATE_ADD(NOW(),INTERVAL 30 DAY))');
  $s->execute([$name,$email,$role,$hash]);
  if($s->rowCount()===1){$count++;$links[]=['email'=>$email,'url'=>rtrim($c['base_url'],'/').'/survey.php?t='.$token];}else{$skip++;}
 }
 fclose($f);$messages[]="Importados: $count; omitidos o duplicados: $skip";
}
page('Administración de invitaciones');
echo '<p>Importa un CSV UTF-8 con encabezado <code>nombre,correo,area</code>. Áreas: docente, coordinacion, jefatura. Los enlaces se muestran una sola vez; entrégalos por un canal seguro.</p>';
echo '<form method="post" enctype="multipart/form-data"><input type="hidden" name="csrf" value="'.h(csrf()).'"><input class="form-control" type="file" name="csv" accept=".csv,text/csv" required><button class="btn btn-primary mt-2">Importar</button></form>';
foreach($messages as $m)echo '<p class="alert alert-info">'.h($m).'</p>';
if($links){echo '<h2 class="h5">Enlaces nuevos (copia ahora)</h2><div class="table-responsive"><table class="table"><thead><tr><th>Correo</th><th>Enlace</th></tr></thead><tbody>';foreach($links as $l)echo '<tr><td>'.h($l['email']).'</td><td class="text-break">'.h($l['url']).'</td></tr>';echo '</tbody></table></div>';}
$counts=$pdo->query('SELECT COUNT(*) total,SUM(used_at IS NOT NULL) completos,SUM(declined_at IS NOT NULL) declinados FROM survey_invites')->fetch();
echo '<p>Invitados: '.(int)$counts['total'].' · Completos: '.(int)$counts['completos'].' · Rechazaron participar: '.(int)$counts['declinados'].'</p><p><a href="results.php">Ver resultados agregados</a></p><form method="post" action="logout.php"><input type="hidden" name="csrf" value="'.h(csrf()).'"><button class="btn btn-outline-secondary">Cerrar sesión</button></form>';endpage();
