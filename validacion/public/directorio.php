<?php
declare(strict_types=1);
require dirname(__DIR__).'/app/bootstrap.php';
require dirname(__DIR__).'/app/reviewer_access.php';
reviewerGuard($c);
header('X-Robots-Tag: noindex, nofollow');
$people=$pdo->query('SELECT full_name,role FROM survey_invites ORDER BY role,full_name')->fetchAll();
$names=['docente'=>'Docente','coordinacion'=>'Coordinación de carrera','jefatura'=>'Jefatura de departamento'];
page('Directorio académico · PID 2.0');
echo '<div class="alert alert-warning">Directorio del personal invitado, separado de las respuestas. <strong>La presencia de un nombre no indica si respondió ni qué contestó.</strong> Uso exclusivo de revisión académica autorizada. No redistribuir.</div>';
echo '<p><a class="btn btn-outline-secondary" href="dashboard.php'.h(reviewerQuery($c)).'">Volver al dashboard</a> <a class="btn btn-success" href="export_excel.php'.h(reviewerQuery($c)).'">Descargar matriz Excel</a></p>';
echo '<table class="table table-striped"><thead><tr><th>Nombre</th><th>Puesto académico</th></tr></thead><tbody>';
foreach($people as $person){echo '<tr><td>'.h($person['full_name']).'</td><td>'.h($names[$person['role']]??$person['role']).'</td></tr>';}
echo '</tbody></table>';endpage();
