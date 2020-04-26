<?php
namespace MyApp\Helper;

use Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\QueryException;


class WriteResponse {


    /**
     * Write response with JSON QueryException infos
     *
     * @param  Response  $response
     * @param  QueryException $e 
     *
     * @return Response
     */
    public static function withQueryException(Response $response, QueryException $e) : Response {
        $exception = array();
        $exception["errorInfo"]["type"] = $e->errorInfo[0] ;
        $exception["errorInfo"]["code"] = $e->errorInfo[1] ;
        $exception["errorInfo"]["message"]  = $e->errorInfo[2] ;
        $payload = json_encode($exception, JSON_PRETTY_PRINT);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

}