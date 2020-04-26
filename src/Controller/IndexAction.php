<?php
namespace MyApp\Controller;

use Psr\Container\ContainerInterface;

class IndexAction
{
   protected $container;

   // constructor receives container instance
   public function __construct(ContainerInterface $container) {
       $this->container = $container;
   }

   public function __invoke($request, $response, $args) {
     // to access items in the container... $this->container->get('');
     $response->getBody()->write("Hello world!");
     return $response;
    }

}