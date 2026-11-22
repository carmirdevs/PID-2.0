<?php
declare(strict_types=1);
require dirname(__DIR__).'/app/bootstrap.php';
requireRole(['admin','reviewer']);
header('X-Robots-Tag: noindex, nofollow');
$q=questions();
page('DEMO · Resultados ficticios de PID 2.0');
echo '<div class="alert alert-warning"><strong>DEMOSTRACIÓN — DATOS TOTALMENTE FICTICIOS.</strong> Ningún resultado de esta pantalla proviene de encuestas reales. No utilizar en el artículo como evidencia empírica.</div>';
echo '<p>Versión ilustrada del instrumento: 1.0 · Invitados ficticios: 60 · Cuestionarios completos ficticios: 48 · Participación ficticia: 80.0%.</p>';
echo '<p><a class="btn btn-outline-secondary btn-sm" href="results.php">Volver a resultados reales</a></p>';
echo '<h2 class="h5">Participación ficticia por puesto</h2><table class="table table-striped"><thead><tr><th>Puesto</th><th>Respuestas ficticias</th></tr></thead><tbody><tr><td>Docente</td><td>32</td></tr><tr><td>Coordinación</td><td>10</td></tr><tr><td>Jefatura</td><td>6</td></tr></tbody></table>';
foreach($q as $index=>$question){
 [$id,$block,$label,$options]=$question;
 $n=count($options);
 if($n<2)continue;
 // Datos deterministas; ningún acceso a tablas de respuestas.
 $values=array_fill(0,$n,0);
 $weights=[];
 for($i=0;$i<$n;$i++)$weights[$i]=($i+1)*($i+1)+(($index+$i)%3);
 $sum=array_sum($weights);$allocated=0;
 for($i=0;$i<$n-1;$i++){$values[$i]=(int)floor(48*$weights[$i]/$sum);$allocated+=$values[$i];}
 $values[$n-1]=48-$allocated;
 echo '<section class="card p-3 mb-3"><h2 class="h6">'.h($id).' · '.h($label).'</h2><p class="small text-warning-emphasis fw-bold">Datos ficticios de demostración (n=48)</p>';
 if(in_array($block,['B','C','D'],true)&&$n>=4){
  $valid=array_sum(array_slice($values,0,4));
  $fav=$values[2]+$values[3];
  echo '<p>Valoraciones favorables ficticias: '.($valid?number_format($fav*100/$valid,1).'%':'Sin respuestas valorativas').' · n válido ficticio: '.$valid.'</p>';
 }
 foreach($options as $i=>$option){
  $pct=$values[$i]*100/48;
  echo '<div class="mb-2"><div class="d-flex justify-content-between gap-2"><span>'.h(chr(65+$i).'. '.$option).'</span><span class="text-nowrap">'.$values[$i].' ('.number_format($pct,1).'%)</span></div><div class="progress" role="img" aria-label="Porcentaje ficticio '.h(number_format($pct,1)).'"><div class="progress-bar" style="width:'.number_format($pct,2,'.','').'%"></div></div></div>';
 }
 echo '</section>';
}
endpage();
