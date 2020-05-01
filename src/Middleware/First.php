<?php
namespace MyApp\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

use Psr\Container\ContainerInterface;

class First
{

    /**
     * Example middleware invokable class
     *
     * @param  ServerRequest  $request PSR-7 request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $uriInterface = $request->getUri();
        $uri = $uriInterface->getPath();
        $test = substr($uri, -1);
        if ($test == "/") {
            //Trailing / in route patterns
            $uri = rtrim($uri, "/\\");
            $request = $request->withUri($uriInterface->withPath($uri));
        }
        $response = $handler->handle($request);
        return $response;
    }
}