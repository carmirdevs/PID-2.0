<?php
/** Enlace de revisión sin contraseña, firmado con el secreto existente. */
declare(strict_types=1);
function reviewerToken(array $c): string {
    return hash_hmac('sha256', 'PID20-VALIDACION-REVISOR-DASHBOARD-V1', $c['rate_secret']);
}
function reviewerAccess(array $c): bool {
    $given=(string)($_GET['k']??'');
    return strlen($given)===64 && ctype_xdigit($given) && hash_equals(reviewerToken($c), $given);
}
function reviewerGuard(array $c): void {
    if (isset($_SESSION['staff_role']) && in_array($_SESSION['staff_role'], ['admin','reviewer'],true)) return;
    if (reviewerAccess($c)) return;
    http_response_code(403);exit('Enlace de revisión inválido');
}
function reviewerQuery(array $c): string {
    return reviewerAccess($c) ? '?k='.rawurlencode((string)$_GET['k']) : '';
}
