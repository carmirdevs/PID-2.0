<?php
$common=['Nada pertinente','Poco pertinente','Pertinente','Muy pertinente','No cuento con información suficiente para valorar'];
$items=[
['P09','B','RF-01','¿Qué tan pertinente considera que PID 2.0 permita registrar las planeaciones didácticas asociándolas con el periodo escolar, la asignatura, el grupo y el docente responsable?','P2-V'],
['P10','B','RF-02','¿Qué tan pertinente considera organizar cada planeación didáctica por unidades temáticas y actividades específicas?','P2-V'],
['P11','B','RF-03','¿Qué tan pertinente considera registrar fechas programadas de inicio y finalización para cada actividad académica?','P2-V'],
['P12','B','RF-04','¿Qué tan pertinente considera conservar una versión inicial de la planeación didáctica que permita consultar lo originalmente programado?','P2-V;P2-E'],
['P13','B','RF-05','¿Qué tan pertinente considera registrar las fechas reales de ejecución y el estado de cumplimiento de cada actividad?','P2-V'],
['P14','B','RF-06','¿Qué tan pertinente considera disponer de un procedimiento electrónico para solicitar modificaciones a actividades o fechas, indicando su justificación?','P2-V'],
['P15','B','RF-07','¿Qué tan pertinente considera que las solicitudes de modificación sean aprobadas o rechazadas exclusivamente por el responsable académico competente?','P2-V;P2-E'],
['P16','B','RF-08','¿Qué tan pertinente considera que los cambios autorizados generen una nueva versión de la planeación y que los rechazados no modifiquen la versión vigente?','P2-V;P2-E'],
['P17','B','RF-09','¿Qué tan pertinente considera disponer de un historial que permita consultar versiones, modificaciones, responsables y decisiones relacionadas con la planeación didáctica?','P2-V'],
['P18','B','RF-10','¿Qué tan pertinente considera visualizar indicadores de avance de las actividades, unidades temáticas y planeaciones didácticas?','P1-R;P2-V'],
['P19','B','RF-11','¿Qué tan pertinente considera generar reportes académicos por periodo escolar, asignatura, grupo y estado de cumplimiento de actividades?','P1-R;P2-V'],
['P20','B','RF-12','¿Qué tan pertinente considera conservar la posibilidad de cargar y consultar archivos de instrumentación didáctica en formato Excel XLSX, además de las nuevas funciones de seguimiento?','P1-D;P2-V'],
['P21','C','RNF-01','¿Qué tan pertinente considera que PID 2.0 incorpore mecanismos de protección de contraseñas para evitar que puedan consultarse directamente desde la base de datos?','P2-S'],
['P22','C','RNF-02','¿Qué tan pertinente considera que PID 2.0 proteja las sesiones de usuario para reducir el riesgo de accesos indebidos a las cuentas?','P2-S'],
['P23','C','RNF-03','¿Qué tan pertinente considera que cada usuario pueda realizar únicamente las operaciones autorizadas para su función académica?','P2-S'],
['P24','C','RNF-04','¿Qué tan pertinente considera que el sistema incorpore mecanismos para impedir que se registren modificaciones o autorizaciones mediante solicitudes electrónicas no legítimas?','P2-S'],
['P25','C','RNF-05','¿Qué tan pertinente considera proteger los registros históricos de autorizaciones y rechazos para impedir su modificación o eliminación por usuarios sin facultades para ello?','P2-S'],
['P26','C','RNF-06','¿Qué tan pertinente considera que los documentos académicos almacenados en PID 2.0 solo puedan consultarse por usuarios con permisos correspondientes?','P2-S'],
['P27','C','RNF-07','¿Qué tan pertinente considera que el sistema verifique los archivos Excel cargados para reducir errores, archivos inválidos y riesgos de seguridad?','P2-S'],
['P28','D','RN-01','¿Qué tan pertinente considera que el docente pueda registrar el cumplimiento de sus actividades, pero que la autorización de modificaciones a su planeación corresponda a un responsable académico facultado?','P2-V;P2-E'],
['P29','D','RN-02','¿Qué tan pertinente considera que una modificación autorizada conserve intacta la versión original de la planeación didáctica?','P2-V;P2-E'],
['P30','D','RN-03','¿Qué tan pertinente considera que las solicitudes rechazadas queden registradas junto con su decisión y que no produzcan cambios en la planeación vigente?','P2-V;P2-E'],
['P31','D','RN-04','¿Qué tan pertinente considera que la facultad de autorizar modificaciones dependa del puesto y ámbito de responsabilidad académica, y no de una persona específica?','P2-V;P2-E'],
['P32','D','RN-05','¿Qué tan pertinente considera que las fórmulas de avance, fechas límite y estados de cumplimiento utilizados por PID 2.0 sean definidos y aprobados previamente por las autoridades académicas competentes?','P1-R;P2-V'],
];
$out=[];foreach($items as [$id,$block,$ref,$q,$trace]){$out[]=[$id,$block,$q,$common,$trace,$ref];}
return $out;
