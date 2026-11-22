<?php
declare(strict_types=1);
require dirname(__DIR__).'/app/bootstrap.php';
require dirname(__DIR__).'/app/reviewer_access.php';
reviewerGuard($c);
require dirname(__DIR__).'/app/report_helpers.php';
$d=reportData($pdo);
page('Dashboard · PID 2.0');
echo '<div class="alert alert-info">Resultados reales agregados. Las distribuciones con participación insuficiente se ocultan para proteger la confidencialidad. No se muestran nombres ni correos.</div>';
echo '<nav class="d-flex gap-2 flex-wrap mb-4"><a class="btn btn-success" href="export_excel.php'.h(reviewerQuery($c)).'">Descargar matriz Excel</a></nav>';
echo '<div class="row row-cols-1 row-cols-md-3 g-3 mb-4">';
foreach([['Invitados',$d['invited']],['Cuestionarios completos',$d['total']],['Participación',$d['invited']?number_format($d['total']*100/$d['invited'],1).'%':'0%']] as $metric){
 echo '<div class="col"><div class="card p-3"><div class="text-muted">'.h($metric[0]).'</div><div class="fs-3 fw-bold">'.h((string)$metric[1]).'</div></div></div>';
}
echo '</div>';
echo '<p><a class="btn btn-outline-primary" href="directorio.php'.h(reviewerQuery($c)).'">Directorio académico (sin correos)</a></p>';
echo '<h2 class="h5">Participación por puesto</h2>';
if($d['roleSafe']) {
 foreach($d['roleCounts'] as $role=>$n) {
  $pct=$d['total']?$n*100/$d['total']:0;
  echo '<div class="mb-2"><div class="d-flex justify-content-between"><span>'.h($role).'</span><span>'.$n.'</span></div><div class="progress"><div class="progress-bar" style="width:'.number_format($pct,2,'.','').'%"></div></div></div>';
 }
} else echo '<p class="text-muted">Desglose por puesto suprimido por confidencialidad.</p>';
echo '<h2 class="h5 mt-4">Gráficos por pregunta</h2>';
foreach($d['items'] as $item) {
 echo '<section class="card p-3 mb-3"><h3 class="h6">'.h($item['id'].' · '.$item['label']).'</h3>';
 if(!$item['safe']) {echo '<p class="text-muted mb-0">Gráfico no disponible: participación insuficiente o celdas pequeñas.</p></section>';continue;}
 if($item['valid']!==null) {
  $favPct=$item['valid']?number_format(100*$item['fav']/$item['valid'],1):'N/D';
  echo '<p class="small">Valoración favorable: '.h((string)$favPct).'% · Respuestas valorativas: '.$item['valid'].'</p>';
 }
 foreach($item['options'] as $i=>$option) {
  $n=$item['counts'][$i];$pct=$d['total']?$n*100/$d['total']:0;
  echo '<div class="mb-2"><div class="d-flex justify-content-between gap-2"><span>'.h(chr(65+$i).'. '.$option).'</span><span class="text-nowrap">'.$n.' ('.number_format($pct,1).'%)</span></div><div class="progress" role="img" aria-label="Porcentaje '.number_format($pct,1).'%"><div class="progress-bar" style="width:'.number_format($pct,2,'.','').'%"></div></div></div>';
 }
 echo '</section>';
}
endpage();
