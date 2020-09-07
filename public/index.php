<?php

require __DIR__ . '/../vendor/autoload.php';

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Container\ContainerInterface;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Http\Server\RequestHandlerInterface;

$caminho = $_SERVER['PATH_INFO'];
$rotas = require __DIR__ . '/../config/routes.php';

if ( ! array_key_exists($caminho, $rotas)) {
    http_response_code(404);
    exit();
}

session_start();

$ehRotaDeLogin = stripos($caminho, 'login');
if ( ! isset($_SESSION['logado']) && $ehRotaDeLogin === false) {
    header('Location: /login');
    exit();
}

$psr17Factory = new Psr17Factory();

$creator = new ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);

$request = $creator->fromGlobals();

$classControladora = $rotas[$caminho];

/**
 * @var ContainerInterface $container
 */
$container = require __DIR__ . '/../config/dependencies.php';

/**
 * @var RequestHandlerInterface $controlador
 */
$controlador = $container->get($classControladora);

$response = $controlador->handle($request);

foreach ($response->getHeaders() as $header => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $header, $value), false);
    }
}

echo $response->getBody();