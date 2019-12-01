<?php

use App\Kernel;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;

require dirname(__DIR__).'/config/bootstrap.php';

if ($_SERVER['APP_DEBUG']) {
    umask(0000);

    Debug::enable();
}

var_dump($_SERVER['DOCUMENT_ROOT']);die;
if ($trustedProxies = $_SERVER['TRUSTED_PROXIES'] ?? $_ENV['TRUSTED_PROXIES'] ?? false) {
    Request::setTrustedProxies(explode(',', $trustedProxies), Request::HEADER_X_FORWARDED_ALL ^ Request::HEADER_X_FORWARDED_HOST);
}

if ($trustedHosts = $_SERVER['TRUSTED_HOSTS'] ?? $_ENV['TRUSTED_HOSTS'] ?? false) {
    Request::setTrustedHosts([$trustedHosts]);
}

$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$request = Request::createFromGlobals();

Request::setTrustedProxies(
// trust *all* requests (the 'REMOTE_ADDR' string is replaced at
// run time by $_SERVER['REMOTE_ADDR'])
    ['127.0.0.1', 'REMOTE_ADDR'],

    // if you're using ELB, otherwise use a constant from above
    Request::HEADER_X_FORWARDED_AWS_ELB
);

$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
