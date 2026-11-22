<?php
require dirname(__DIR__).'/app/bootstrap.php';
if($_SERVER['REQUEST_METHOD']!=='POST'){http_response_code(405);exit;}
checkcsrf();$_SESSION=[];session_destroy();header('Location: login.php');
