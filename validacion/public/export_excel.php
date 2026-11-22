<?php
declare(strict_types=1);
require dirname(__DIR__).'/app/bootstrap.php';
require dirname(__DIR__).'/app/reviewer_access.php';
reviewerGuard($c);
require dirname(__DIR__).'/app/report_helpers.php';
if(!class_exists('ZipArchive')){http_response_code(503);exit('El servidor requiere la extensión PHP ZipArchive para exportar Excel.');}
$d=reportData($pdo);
function excelXml(string $value):string {
 $value=preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/u','',$value)??'';
 return htmlspecialchars($value,ENT_XML1|ENT_QUOTES,'UTF-8');
}
function excelCol(int $index):string {
 $result='';$index++;
 while($index>0){$index--; $result=chr(65+$index%26).$result;$index=intdiv($index,26);}
 return $result;
}
function sheetXml(array $rows):string {
 $xml='<?xml version="1.0" encoding="UTF-8" standalone="yes"?><worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"><sheetViews><sheetView workbookViewId="0"/></sheetViews><sheetData>';
 foreach($rows as $r=>$cells){
  $xml.='<row r="'.($r+1).'">';
  foreach($cells as $c=>$value){
   $ref=excelCol($c).($r+1);
   if(is_int($value)||is_float($value))$xml.='<c r="'.$ref.'"><v>'.$value.'</v></c>';
   else $xml.='<c r="'.$ref.'" t="inlineStr"><is><t>'.excelXml((string)$value).'</t></is></c>';
  }
  $xml.='</row>';
 }
 return $xml.'</sheetData></worksheet>';
}
$summary=[
 ['MATRIZ DE ANÁLISIS PID 2.0 · Instrumento 1.0'],
 ['Tipo','Resultados reales agregados; supresión de celdas pequeñas'],
 ['Invitados',$d['invited']],
 ['Completos',$d['total']],
 ['Participación (%)',$d['invited']?round(100*$d['total']/$d['invited'],2):0],
 ['Advertencia','Los resultados describen a quienes participaron, no necesariamente a toda la población.'],
 ['Confidencialidad','Los nombres se muestran solo en Directorio, sin estado de participación ni respuestas individuales; no se exportan correos.'],
 ['Puesto','Participantes (si es seguro divulgar)']
];
foreach($d['roleCounts'] as $role=>$n)$summary[]=[$role,$d['roleSafe']?$n:'SUPRIMIDO'];
$matrix=[['Pregunta','Bloque','Enunciado','Opción','Conteo','Porcentaje','N valorativo','Favorables (%)','Estado']];
foreach($d['items'] as $item){
 foreach($item['options'] as $i=>$option){
  $matrix[]=[
   $item['id'],$item['block'],$item['label'],chr(65+$i).'. '.$option,
   $item['safe']?$item['counts'][$i]:'SUPRIMIDO',
   $item['safe']&&$d['total']?round(100*$item['counts'][$i]/$d['total'],2):'SUPRIMIDO',
   $item['safe']&&$item['valid']!==null?$item['valid']:'NO DISPONIBLE',
   $item['safe']&&$item['valid']!==null&&$item['valid']>0?round(100*$item['fav']/$item['valid'],2):'NO DISPONIBLE',
   $item['safe']?'AGREGADO':'SUPRIMIDO POR CONFIDENCIALIDAD'
  ];
 }
}
$directory=[['Nombre','Puesto académico']];
$roleLabels=['docente'=>'Docente','coordinacion'=>'Coordinación de carrera','jefatura'=>'Jefatura de departamento'];
foreach($pdo->query('SELECT full_name,role FROM survey_invites ORDER BY role,full_name') as $person){
 $directory[]=[$person['full_name'],$roleLabels[$person['role']]??$person['role']];
}
$temporary=tempnam(sys_get_temp_dir(),'pidxlsx_');
if($temporary===false){http_response_code(500);exit('No se pudo preparar la exportación');}
$zip=new ZipArchive();
if($zip->open($temporary,ZipArchive::OVERWRITE)!==true){@unlink($temporary);http_response_code(500);exit('Error al preparar Excel');}
$zip->addFromString('[Content_Types].xml','<?xml version="1.0" encoding="UTF-8"?><Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types"><Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/><Default Extension="xml" ContentType="application/xml"/><Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/><Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/><Override PartName="/xl/worksheets/sheet2.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/><Override PartName="/xl/worksheets/sheet3.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/></Types>');
$zip->addFromString('_rels/.rels','<?xml version="1.0" encoding="UTF-8"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/></Relationships>');
$zip->addFromString('xl/workbook.xml','<?xml version="1.0" encoding="UTF-8"?><workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"><sheets><sheet name="Resumen" sheetId="1" r:id="rId1"/><sheet name="Matriz por pregunta" sheetId="2" r:id="rId2"/><sheet name="Directorio académico" sheetId="3" r:id="rId3"/></sheets></workbook>');
$zip->addFromString('xl/_rels/workbook.xml.rels','<?xml version="1.0" encoding="UTF-8"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/><Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet2.xml"/><Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet3.xml"/></Relationships>');
$zip->addFromString('xl/worksheets/sheet1.xml',sheetXml($summary));
$zip->addFromString('xl/worksheets/sheet2.xml',sheetXml($matrix));
$zip->addFromString('xl/worksheets/sheet3.xml',sheetXml($directory));
$zip->close();
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="PID20_Matriz_Analisis_Agregada.xlsx"');
header('Content-Length: '.filesize($temporary));
header('Cache-Control: private, no-store');
readfile($temporary);@unlink($temporary);exit;
