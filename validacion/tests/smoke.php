<?php
declare(strict_types=1);
if(PHP_SAPI!=='cli')exit(2);
$q=array_merge(require __DIR__.'/../app/questions.php',require __DIR__.'/../app/more_questions.php',require __DIR__.'/../app/last_questions.php');
assert(count($q)===37);
$ids=array_column($q,0);
foreach(range(1,37) as $i){$id=sprintf('P%02d',$i);if(!in_array($id,$ids,true))throw new RuntimeException('Falta '.$id);}
if(count(array_unique($ids))!==37)throw new RuntimeException('Duplicados');
foreach($q as $item){if(count($item)<5||count($item[3])<4)throw new RuntimeException('Pregunta inválida');}
$c=require __DIR__.'/../app/consent.php';
if(hash('sha256',$c['text'])!==$c['sha256'])throw new RuntimeException('Consentimiento alterado');
echo "OK: 37 preguntas, IDs únicos, opciones y hash de consentimiento\n";
