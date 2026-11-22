<?php
declare(strict_types=1);
$configFile=__DIR__.'/config.local.php';
if (!is_file($configFile)) {http_response_code(503);exit('Configuración pendiente');}
$c=require $configFile;
if (!is_array($c)) {exit('Configuración inválida');}
if (PHP_SAPI!=='cli') {
 if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS']==='off') {http_response_code(403);exit('HTTPS obligatorio');}
 session_name('PID20VAL');
 session_set_cookie_params(['lifetime'=>0,'path'=>'/','secure'=>true,'httponly'=>true,'samesite'=>'Lax']);
 session_start();
 header('X-Content-Type-Options: nosniff');header('Referrer-Policy: no-referrer');
 header('Cache-Control: no-store');header('X-Frame-Options: DENY');
}
if (empty($c['rate_secret']) || strlen($c['rate_secret'])<32) {http_response_code(503);exit('Configurar rate_secret');}
$pdo=new PDO('mysql:host='.$c['host'].';dbname='.$c['database'].';charset=utf8mb4',$c['username'],$c['password'],[
 PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>false]);
function h(string $s):string{return htmlspecialchars($s,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8');}
function csrf():string{return $_SESSION['csrf']??=bin2hex(random_bytes(32));}
function checkcsrf():void{if(!hash_equals(csrf(),(string)($_POST['csrf']??''))){http_response_code(403);exit('Solicitud inválida');}}
function questions():array{return array_merge(require __DIR__.'/questions.php',require __DIR__.'/more_questions.php',require __DIR__.'/last_questions.php');}
function page(string $title):void{echo '<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>'.h($title).'</title><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"></head><body class="bg-light"><main class="container py-4" style="max-width:980px"><h1 class="h3 mb-4">'.h($title).'</h1>';}
function endpage():void{echo '</main></body></html>';}
function requireRole(array $roles):void{if(!isset($_SESSION['staff_role'])||!in_array($_SESSION['staff_role'],$roles,true)){http_response_code(403);exit('Acceso denegado');}}

/** Contador de intentos, sin persistir IP en claro. Limita por ventana y bloquea temporalmente. */
function rateKey(string $kind,string $subject):string{global $c;return hash_hmac('sha256',$kind.'|'.$subject,$c['rate_secret']);}
function rateBlocked(string $key):bool{global $pdo;
 $q=$pdo->prepare('SELECT blocked_until FROM survey_rate_limits WHERE rate_key=?');$q->execute([$key]);$v=$q->fetchColumn();
 return $v!==false && $v!==null && strtotime((string)$v)>time();
}
function rateFail(string $key,int $max=5):void{global $pdo;
 $q=$pdo->prepare("INSERT INTO survey_rate_limits(rate_key,failures,window_started,blocked_until) VALUES(?,1,NOW(),NULL) ON DUPLICATE KEY UPDATE failures=IF(window_started < DATE_SUB(NOW(),INTERVAL 15 MINUTE),1,failures+1), window_started=IF(window_started < DATE_SUB(NOW(),INTERVAL 15 MINUTE),NOW(),window_started), blocked_until=IF(failures >= ?,DATE_ADD(NOW(),INTERVAL 15 MINUTE),blocked_until)");
 $q->execute([$key,$max]);
}
function rateClear(string $key):void{global $pdo;$q=$pdo->prepare('DELETE FROM survey_rate_limits WHERE rate_key=?');$q->execute([$key]);}
