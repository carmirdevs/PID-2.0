<?php
require dirname(__DIR__).'/app/bootstrap.php';requireRole(['admin','reviewer']);require dirname(__DIR__).'/app/reviewer_access.php';
$q=questions();$counts=$pdo->query('SELECT respondent_role,COUNT(*) n FROM survey_submissions GROUP BY respondent_role')->fetchAll();
$roles=['docente'=>0,'coordinacion'=>0,'jefatura'=>0];foreach($counts as $r)$roles[$r['respondent_role']]=(int)$r['n'];
$total=array_sum($roles);$invited=(int)$pdo->query('SELECT COUNT(*) FROM survey_invites')->fetchColumn();
$rows=$pdo->query('SELECT question_id,choice_index,COUNT(*) n FROM survey_answers GROUP BY question_id,choice_index')->fetchAll();$stats=[];foreach($rows as $r)$stats[$r['question_id']][(int)$r['choice_index']]=(int)$r['n'];
page('Resultados agregados · PID 2.0');
if (($_SESSION['staff_role']??'')==='admin') {
  $link='https://'.($_SERVER['HTTP_HOST']??'itsjrc.net').rtrim(dirname($_SERVER['SCRIPT_NAME']??'/validacion/public/results.php'),'/').'/dashboard.php?k='.reviewerToken($c);
  echo '<div class="alert alert-secondary"><strong>Enlace privado para el docente (sin usuario ni contraseña):</strong><div class="mt-2"><input type="text" class="form-control" readonly value="'.h($link).'" onclick="this.select()"></div><small>Comparte este enlace únicamente con el docente. Quien lo tenga podrá consultar datos agregados. No lo publiques.</small></div>';
}

echo '<nav class="d-flex flex-wrap gap-2 mb-3"><a class="btn btn-primary" href="dashboard.php">Dashboard de gráficos</a><a class="btn btn-success" href="export_excel.php">Descargar matriz Excel (.xlsx)</a><a class="btn btn-outline-primary" href="directorio.php">Directorio académico</a></nav>';

if (($_SESSION['staff_role']??'')==='admin') echo '<div class="alert alert-info"><strong>Prueba visual:</strong> <a class="btn btn-sm btn-primary ms-2" href="results_demo.php">Ver demostración con datos ficticios</a> <span class="small">No utiliza respuestas reales.</span></div>';
echo '<p>Versión del instrumento: 1.0 · Invitados: '.$invited.' · Cuestionarios completos: '.$total.' · Participación: '.($invited?number_format($total*100/$invited,1):'0').'%. Las respuestas describen a quienes participaron, no necesariamente a toda la población.</p>';
echo '<h2 class="h5">Participación por puesto</h2><table class="table"><tr><th>Puesto</th><th>Respuestas</th></tr>';

$roleDisclosureSafe=true;foreach($roles as $n){if($n>0 && $n<5)$roleDisclosureSafe=false;}
foreach($roles as $role=>$n)echo '<tr><td>'.h($role).'</td><td>'.($roleDisclosureSafe && $n>=5?$n:'Suprimido por confidencialidad').'</td></tr>';echo '</table>';
foreach($q as [$id,$block,$label,$options]){
 $smallCell=false;foreach($options as $i=>$o){$n=$stats[$id][$i]??0;if($n>0&&$n<5)$smallCell=true;}
 $showDetail=($total>=5 && !$smallCell);
 echo '<section class="card p-3 mb-3"><h2 class="h6">'.h($id).' · '.h($label).'</h2>';
 if(!$showDetail)echo '<p class="small text-muted">Detalle suprimido por confidencialidad (celdas pequeñas o participación insuficiente).</p>';
 $valid=0;if(in_array($block,['B','C','D'],true))foreach([0,1,2,3] as $i)$valid+=($stats[$id][$i]??0);
 if(in_array($block,['B','C','D'],true)&&$showDetail){$fav=($stats[$id][2]??0)+($stats[$id][3]??0);echo '<p>Valoraciones favorables: '.($valid?number_format($fav*100/$valid,1).'%':'Sin respuestas valorativas').' · n válido: '.$valid.'</p>';}
 foreach($options as $i=>$o){$n=$stats[$id][$i]??0;$pct=$total?$n*100/$total:0;
  echo '<div class="mb-2"><div class="d-flex justify-content-between"><span>'.h(chr(65+$i).'. '.$o).'</span><span>'.($showDetail?$n.' ('.number_format($pct,1).'%)':'No disponible').'</span></div>';
  if($showDetail)echo '<div class="progress" role="img" aria-label="'.h(number_format($pct,1)).'%"><div class="progress-bar" style="width:'.number_format($pct,2,'.','').'%"></div></div>';echo '</div>';
 }echo '</section>';
}
echo '<form method="post" action="logout.php"><input type="hidden" name="csrf" value="'.h(csrf()).'"><button class="btn btn-outline-secondary">Cerrar sesión</button></form>';endpage();
