<?php
if (!session_id()) {
    @session_start();
}

require_once '../vendor/autoload.php';

use Delight\Auth\Auth;
use DI\ContainerBuilder;
use League\Plates\Engine;
use Aura\SqlQuery\QueryFactory;



$builder = new ContainerBuilder();
$builder->addDefinitions([
    Engine::class => function() {
        return new Engine('../app/view');
    },
    QueryFactory::class => function() {
        return new QueryFactory('mysql');
    },
    PDO::class => function() {
        return new PDO('mysql:host=localhost;dbname=project;charset=utf8', 'root', 'root');
    },
    Auth::class => function($builder) {
        return new Auth($builder->get('PDO'), null, null, false);
    }
]);

$container = $builder->build();

$dispatcher = FastRoute\simpleDispatcher (function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/[{page:\d+}]', ['App\Controller\ViewController', 'users']);
    $r->addRoute('GET', '/register', ['App\Controller\ViewController', 'registerForm']);
    $r->addRoute('GET', '/login', ['App\Controller\ViewController', 'loginForm']);
    
    $r->addRoute('GET', '/create', ['App\Controller\RegisterController', 'createUserForm']);
    $r->addRoute('GET', '/delete', ['App\Controller\RegisterController', 'deleteUser']);
    $r->addRoute('POST', '/registrationMake', ['App\Controller\RegisterController', 'registerUser']);
    $r->addRoute('POST', '/createuser', ['App\Controller\RegisterController', 'createUser']);

    
    $r->addRoute('GET', '/profile', ['App\Controller\UserController', 'profile']);
    $r->addRoute('GET', '/contacts', ['App\Controller\UserController', 'contactsForm']);
    $r->addRoute('GET', '/edit', ['App\Controller\UserController', 'userInfo']);
    $r->addRoute('GET', '/status', ['App\Controller\UserController', 'statusForm']);
    $r->addRoute('GET', '/mediapage', ['App\Controller\UserController', 'mediaForm']);
    $r->addRoute('GET', '/security', ['App\Controller\UserController', 'securityForm']);
    $r->addRoute('POST', '/editcontacts', ['App\Controller\UserController', 'editContacts']);
    $r->addRoute('POST', '/editMake', ['App\Controller\UserController', 'editUserInfo']);
    $r->addRoute('POST', '/setstatus', ['App\Controller\UserController', 'setStatus']);
    $r->addRoute('POST', '/changeavatar', ['App\Controller\UserController', 'uploadAvatar']);
    $r->addRoute('POST', '/securitychange', ['App\Controller\UserController', 'updateCredentials']);
    $r->addRoute('GET', '/logout', ['App\Controller\AuthorizationController', 'logout']);
    $r->addRoute('POST', '/loginMake', ['App\Controller\AuthorizationController', 'login']);
});


// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    // ... 404 Not Found
    case FastRoute\Dispatcher::NOT_FOUND:
        $handler = ['App\Controller\ViewController', 'error404'];
        $container->call($handler);
        break;
        
    // ... 405 Method Not Allowed
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        $handler = ['App\Controller\ViewController', 'error405'];
        $container->call($handler);
        break;

    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $container->call($handler, $vars);
        break;
}