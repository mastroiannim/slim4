<?php
namespace MyApp\Controller;

use Psr\Container\ContainerInterface;
use Illuminate\Database\QueryException;

use MyApp\Helper\WriteResponse;
use Illuminate\Database\Capsule\Manager as Capsule;

class DBInitAction
{
   private $container;
   private $db;

    // constructor receives container instance
    public function __construct(ContainerInterface $container, Capsule $db) {
        $this->container = $container;
        $this->db = $db;
    }

    public function __invoke($request, $response, $args) {       
        try{
            $this->db::schema()->create('users', function ($table) {
                $table->increments('id');
                $table->string('email')->unique();
                $table->string('name');
                $table->timestamps();
            });

            $response->getBody()->write("DB Creato!");

        }catch(QueryException $e){

            $response = WriteResponse::withQueryException($response, $e);
        }
        
        return $response;
    }

}