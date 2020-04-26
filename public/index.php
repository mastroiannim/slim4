<?php
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;
use Slim\Psr7\Response as ResponseImpl;
use Slim\Middleware\MethodOverrideMiddleware;

use MyApp\Middleware\First;
use MyApp\Model\User;
use MyApp\Controller\IndexAction;
use MyApp\Controller\DBInitAction;
use MyApp\Controller\Home\HomeController;
use MyApp\Controller\Hello\HelloController;

require __DIR__ . '/../vendor/autoload.php';

// Set up settings
$injectSettingsIn = require  __DIR__ . '/../conf/settings.php';

// Create Container using PHP-DI
$container = new Container();

// Inject Services
$injectSettingsIn($container);

// Configure the application via container
$app = AppFactory::createFromContainer($container);

/**
 * The routing middleware should be added earlier than the ErrorMiddleware
 * Otherwise exceptions thrown from it will not be handled by the middleware
 */
// Add RoutingMiddleware before we add the MethodOverrideMiddleware so the method is overrode before routing is done
$app->addRoutingMiddleware();

/**
 * @param bool $displayErrorDetails -> Should be set to false in production
 * @param bool $logErrors -> Parameter is passed to the default ErrorHandler
 * @param bool $logErrorDetails -> Display error details in error log
 * which can be replaced by a callable of your choice.
 * @param \Psr\Log\LoggerInterface $logger -> Optional PSR-3 logger to receive errors
 * 
 * Note: This middleware should be added last. It will not handle any exceptions/errors
 * for middleware added after it.
 */
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Add MethodOverride middleware
$methodOverrideMiddleware = new MethodOverrideMiddleware();
$app->add($methodOverrideMiddleware);

$app->addBodyParsingMiddleware();

$app->get('/db/init', DBInitAction::class);

$app->get('/', IndexAction::class);

$app->get('/home', HomeController::class);

$app->get('/home/contact', HomeController::class . ':contact');

$app->get('/hello', HelloController::class . ':all');

$app->get('/hello/{id}', HelloController::class . ':get');

$app->put('/hello', HelloController::class . ':put');



$addHeaderMiddleware = function (Request $request, RequestHandler $handler) {
    $response = $handler->handle($request);
    return $response->withAddedHeader('mio', 'test');
};

$removeHeaderMiddleware = function (Request $request, RequestHandler $handler) {	
    $response = $handler->handle($request);
    return $response->withoutHeader('mio');
};

$app->add(new First($container));
$app->add($addHeaderMiddleware);
$app->add($removeHeaderMiddleware);

$app->run();