<?php
require dirname(__DIR__).'/app/bootstrap.php';
$surveyKey=rateKey('survey',(string)($_SERVER['REMOTE_ADDR']??'unknown'));
if(rateBlocked($surveyKey)){http_response_code(429);header('Retry-After: 900');exit('Demasiados intentos. Intente más tarde.');}
$t=(string)($_GET['t']??$_POST['t']??'');if(!preg_match('/^[a-f0-9]{64}$/D',$t)){rateFail($surveyKey,10);http_response_code(404);exit('Enlace inválido');}
$hash=hash('sha256',$t);$s=$pdo->prepare('SELECT * FROM survey_invites WHERE token_hash=? AND used_at IS NULL AND declined_at IS NULL AND expires_at>NOW()');$s->execute([$hash]);$invite=$s->fetch();if(!$invite){rateFail($surveyKey,10);http_response_code(410);exit('Enlace no disponible');}
$q=questions();$error='';$consent=require dirname(__DIR__).'/app/consent.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
 checkcsrf();$action=(string)($_POST['action']??'');
 if($action==='decline'){$s=$pdo->prepare('UPDATE survey_invites SET declined_at=NOW() WHERE id=? AND used_at IS NULL AND declined_at IS NULL');$s->execute([$invite['id']]);echo 'Gracias. No se registraron respuestas.';exit;}
 if($action==='submit'&&($_POST['consent']??'')==='yes' && hash_equals($consent['version'],(string)($_POST['consent_version']??''))){
  $answers=[];
  foreach($q as $question){[$id,,$label,$options]=$question;$v=$_POST['q'][$id]??null;
   if(!is_string($v)||!ctype_digit($v)||((int)$v)<0||((int)$v)>=count($options)){$error='Responde las 37 preguntas para finalizar.';break;}
   $answers[$id]=(int)$v;
  }
  if(!$error){
   try{$pdo->beginTransaction();
    $lock=$pdo->prepare('SELECT id,role FROM survey_invites WHERE id=? AND used_at IS NULL AND declined_at IS NULL AND expires_at>NOW() FOR UPDATE');$lock->execute([$invite['id']]);$active=$lock->fetch();if(!$active)throw new RuntimeException('Invitación ya utilizada');
    $ins=$pdo->prepare("INSERT INTO survey_submissions(respondent_role,instrument_version) VALUES(?,'1.0')");$ins->execute([$active['role']]);$sid=$pdo->lastInsertId();
    $ans=$pdo->prepare('INSERT INTO survey_answers(submission_id,question_id,choice_index) VALUES(?,?,?)');foreach($answers as $id=>$v)$ans->execute([$sid,$id,$v]);
    $done=$pdo->prepare('UPDATE survey_invites SET used_at=NOW(),consent_accepted_at=NOW(),consent_version=?,consent_sha256=? WHERE id=?');$done->execute([$consent['version'],$consent['sha256'],$active['id']]);$pdo->commit();rateClear($surveyKey);
    page('Cuestionario registrado');echo '<div class="alert alert-success">Gracias por participar. Tus respuestas se registraron correctamente.</div>';endpage();exit;
   }catch(Throwable $e){if($pdo->inTransaction())$pdo->rollBack();$error='No fue posible registrar la respuesta. Intenta nuevamente.';}
  }
 }else{$error='Debes aceptar voluntariamente para responder.';}
}
page('Validación de requerimientos PID 2.0');
echo '<p><strong>Instrumento v1.0 · 37 preguntas.</strong> Investigación doctoral sobre prácticas académicas y pertinencia de los requerimientos PID 2.0. Participación voluntaria. El acceso es individual; nombre y correo se usan para invitación y control de participación. Las respuestas se almacenan sin nombre ni correo, pero no se promete anonimato absoluto. El revisor verá solo resultados agregados. Puedes no participar sin consecuencia laboral o académica. Antes de abrir el levantamiento debe publicarse el aviso de privacidad institucional aplicable y la información de contacto de los responsables.</p>';
if($error)echo '<div class="alert alert-danger">'.h($error).'</div>';
echo '<form method="post"><input type="hidden" name="csrf" value="'.h(csrf()).'"><input type="hidden" name="t" value="'.h($t).'">';
echo '<fieldset class="border rounded p-3 mb-4"><legend class="h5">Consentimiento '.h($consent['version']).'</legend><div class="small" style="white-space:pre-line">'.h($consent['text']).'</div><p>Consulta el aviso institucional: <a href="'.h($c['privacy_url']??'#').'">Aviso de privacidad</a>. Contacto: '.h($c['contact_email']??'pendiente').'</p><input type="hidden" name="consent_version" value="'.h($consent['version']).'"><label><input type="radio" name="consent" value="yes" required> Acepto participar voluntariamente</label></fieldset>';
foreach($q as $question){[$id,$block,$label,$options]=$question;echo '<fieldset class="card p-3 mb-3"><legend class="h6">'.h($id).' · Bloque '.h($block).'</legend><p>'.h($label).'</p>';foreach($options as $i=>$o){$key=h($id.'-'.$i);echo '<label class="d-block mb-2"><input type="radio" name="q['.h($id).']" value="'.$i.'" required> '.h(chr(65+$i).'. '.$o).'</label>';}echo '</fieldset>';}
echo '<button class="btn btn-primary" type="submit" name="action" value="submit">Enviar cuestionario</button> <button class="btn btn-outline-secondary" type="submit" name="action" value="decline" formnovalidate>Prefiero no participar</button></form>';endpage();
