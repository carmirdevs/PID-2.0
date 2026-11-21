<?php
declare(strict_types=1);
/** PID 2.0 INV-02: solo lectura; identidades sintéticas fijas, no autenticación. */
if (PHP_SAPI !== 'cli') { http_response_code(403); exit('Solo PHP CLI'); }
$path = __DIR__ . '/config.local.php';
if (!is_file($path)) { fwrite(STDERR, "Falta config.local.php\n"); exit(2); }
$c = require $path;
foreach (['host','port','database','username','password'] as $k) {
    if (!isset($c[$k]) || $c[$k] === '') { fwrite(STDERR,"Configuración incompleta: $k\n"); exit(2); }
}
try {
    $pdo = new PDO(
        sprintf('mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4', $c['host'], (int)$c['port'], $c['database']),
        $c['username'], $c['password'],
        [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
         PDO::ATTR_EMULATE_PREPARES=>false, PDO::ATTR_TIMEOUT=>8]
    );
    $pdo->exec('SET TRANSACTION READ ONLY');
    $pdo->beginTransaction();
    $db = $pdo->query('SELECT DATABASE()')->fetchColumn();
    if ($db !== $c['database']) { throw new RuntimeException('Base inesperada'); }
    $sql = "SELECT p.id, EXISTS (
        SELECT 1 FROM usuario_roles ur
        JOIN roles r ON r.id=ur.rol_id
        WHERE ur.usuario_id=:usuario
          AND UPPER(r.codigo)='AUTORIZADOR'
          AND ur.ambito_tipo='grupo' AND ur.ambito_id=p.grupo_id
    ) AS competente FROM planeaciones p WHERE p.id=:plan";
    $stmt = $pdo->prepare($sql);
    $cases = [
        ['codigo'=>'INV02-T01','usuario'=>1,'plan'=>1,'esperado'=>false],
        ['codigo'=>'INV02-T02','usuario'=>2,'plan'=>1,'esperado'=>true],
        ['codigo'=>'INV02-T03','usuario'=>2,'plan'=>2,'esperado'=>false],
    ];
    $out=[]; $ok=true;
    foreach ($cases as $case) {
        $stmt->execute(['usuario'=>$case['usuario'],'plan'=>$case['plan']]);
        $row=$stmt->fetch();
        $actual=$row===false ? null : ((int)$row['competente']===1);
        $pass=$actual!==null && $actual===$case['esperado'];
        $ok=$ok && $pass;
        $out[]=['caso'=>$case['codigo'],'usuario_ficticio'=>$case['usuario'],
            'planeacion_ficticia'=>$case['plan'],
            'esperado'=>$case['esperado']?'PERMITIDO':'DENEGADO',
            'observado'=>$actual===null?'SIN_PLANEACION':($actual?'PERMITIDO':'DENEGADO'),
            'resultado'=>$pass?'COINCIDE':'NO_COINCIDE'];
    }
    $pdo->rollBack();
    echo json_encode(['proyecto'=>'PID 2.0 / INV-02','fecha_utc'=>gmdate('c'),
        'motor'=>$pdo->getAttribute(PDO::ATTR_SERVER_VERSION),'base'=>$db,
        'tipo'=>'Evaluación PHP/PDO de solo lectura, identidades sintéticas',
        'resultados'=>$out,'resumen'=>$ok?'TRES_CASOS_COINCIDEN':'REVISION_REQUERIDA',
        'limitacion'=>'No valida autenticación, permisos de escritura, aprobación ni concurrencia'],
        JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR), "\n";
    exit($ok?0:1);
} catch (Throwable $e) {
    if (isset($pdo) && $pdo->inTransaction()) { $pdo->rollBack(); }
    fwrite(STDERR, 'Error en evaluación: '.$e->getMessage()."\n");
    exit(2);
}
