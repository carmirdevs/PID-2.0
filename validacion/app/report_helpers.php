<?php
declare(strict_types=1);
/* Cálculo común de datos agregados, sin identificadores personales. */
function reportData(PDO $pdo):array {
    $questions=questions();
    $invited=(int)$pdo->query('SELECT COUNT(*) FROM survey_invites')->fetchColumn();
    $roleCounts=['docente'=>0,'coordinacion'=>0,'jefatura'=>0];
    foreach($pdo->query('SELECT respondent_role,COUNT(*) n FROM survey_submissions GROUP BY respondent_role') as $r) {
        if(array_key_exists($r['respondent_role'],$roleCounts)) $roleCounts[$r['respondent_role']]=(int)$r['n'];
    }
    $total=array_sum($roleCounts);
    $stats=[];
    foreach($pdo->query('SELECT question_id,choice_index,COUNT(*) n FROM survey_answers GROUP BY question_id,choice_index') as $r) {
        $stats[$r['question_id']][(int)$r['choice_index']]=(int)$r['n'];
    }
    // Evita revelar el único grupo pequeño por diferencia respecto del total.
    $roleSafe=$total>=5;
    foreach($roleCounts as $n)if($n>0 && $n<5)$roleSafe=false;
    $items=[];
    foreach($questions as $question) {
        [$id,$block,$label,$options]=$question;
        $values=[];
        foreach($options as $i=>$option)$values[$i]=$stats[$id][$i]??0;
        $answered=array_sum($values);
        $safe=$total>=5 && $answered===$total;
        foreach($values as $n)if($n>0 && $n<5)$safe=false;
        $valid=in_array($block,['B','C','D'],true)?array_sum(array_slice($values,0,4)):null;
        $fav=$valid===null?null:(($values[2]??0)+($values[3]??0));
        $items[]=['id'=>$id,'block'=>$block,'label'=>$label,'options'=>$options,'counts'=>$values,
          'safe'=>$safe,'valid'=>$valid,'fav'=>$fav];
    }
    return compact('questions','invited','roleCounts','total','roleSafe','items');
}
