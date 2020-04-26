<?php
namespace MyApp\Controller;

use Psr\Container\ContainerInterface;
use Illuminate\Database\QueryException;

use MyApp\Helper\WriteResponse;

class DBInitAction
{
   private $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function __invoke($request, $response, $args) {
        $db = $this->container->get('db');
       
        try{
            $db::schema()->create('users', function ($table) {
                $table->increments('id');
                $table->string('email')->unique();
                $table->string('name');
                $table->timestamps();
            });

            $response->getBody()->write("Hello world!");

        }catch(QueryException $e){

            $response = WriteResponse::withQueryException($response, $e);
        }
        
        return $response;
    }

}