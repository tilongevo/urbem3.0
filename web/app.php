<?php
use Symfony\Component\HttpFoundation\Request;

umask(0002); 
set_time_limit(0);
ini_set('memory_limit','2048M');

/**
 * @var Composer\Autoload\ClassLoader
 */
$loader = require __DIR__.'/../app/autoload.php';
$bootstrapCache = __DIR__.'/../var/bootstrap.php.cache';

if (!file_exists($bootstrapCache)) {
    $bootstrapCache = __DIR__.'/../app/bootstrap.php.cache';
}

include_once $bootstrapCache;

// Enable APC for autoloading to improve performance.
// You should change the ApcClassLoader first argument to a unique prefix
// in order to prevent cache key conflicts with other applications
// also using APC.
/*
$apcLoader = new Symfony\Component\ClassLoader\ApcClassLoader(sha1(__FILE__), $loader);
$loader->unregister();
$apcLoader->register(true);
*/

$env = getenv('SYMFONY__ENV');
$debug = getenv('SYMFONY__DEBUG') ? true : false;

$kernel = new AppKernel($env, $debug);
$kernel->loadClassCache();
//$kernel = new AppCache($kernel);

// When using the HttpCache, you need to call the method in your front controller instead of relying on the configuration parameter
//Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();
Request::setTrustedProxies(array($request->server->get('REMOTE_ADDR')));
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
