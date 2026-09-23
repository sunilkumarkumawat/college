<?php

// Strip leading /public from REQUEST_URI so Laravel routes match properly
if (isset($_SERVER['REQUEST_URI']) && preg_match('#^/public(/.*)?$#', $_SERVER['REQUEST_URI'], $matches)) {
    $_SERVER['REQUEST_URI'] = !empty($matches[1]) ? $matches[1] : '/';
}
if (isset($_SERVER['PHP_SELF']) && preg_match('#^/public(/.*)?$#', $_SERVER['PHP_SELF'], $matches)) {
    $_SERVER['PHP_SELF'] = !empty($matches[1]) ? $matches[1] : '/';
}

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is in maintenance / demo mode via the "down" command
| we will load this file so that any pre-rendered content can be shown
| instead of starting the framework, which could cause an exception.
|
*/

if (file_exists(__DIR__.'/../storage/framework/maintenance.php')) {
    require __DIR__.'/../storage/framework/maintenance.php';
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
);

if (method_exists($response, 'getContent') && method_exists($response, 'setContent')) {
    $content = $response->getContent();
    if (is_string($content)) {
        // Automatically remove /public/ from generated asset and image URLs in HTML output
        $content = preg_replace('#([\'"/])public/(assets|images|qrcode_voice|schoolimage|css|js)/#i', '$1$2/', $content);
        $content = preg_replace('#([\'"/])public/([a-zA-Z0-9_\-\./]+\.(css|js|png|jpg|jpeg|gif|svg|ico|woff2?|ttf|eot|webp|pdf|xlsx?|csv|mp3|mp4|webm))#i', '$1$2', $content);
        $response->setContent($content);
    }
}

$response->send();

$kernel->terminate($request, $response);
