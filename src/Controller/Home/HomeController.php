<?php
namespace MyApp\Controller\Home;

use Psr\Container\ContainerInterface;

class HomeController
{
   protected $container;

   // constructor receives container instance
   public function __construct(ContainerInterface $container) {
       $this->container = $container;
   }

   public function __invoke($request, $response, $args) {
      $form =<<<form
      <form action="/hello" method="post">
          <input type="hidden" name="_METHOD" value="PUT"/>
          <label for="name">First name:</label></br>
          <input type="text" id="name" name="name" value=""></br>
          <button type="submit">Send PUT request</button>
      </form>
      form;
  
      $response->getBody()->write($form);
      return $response;
}

   public function contact($request, $response, $args) {
        // to access items in the container... $this->container->get('');
        $contactInfos = $this->container->get('contact');
        
        $payload = json_encode($contactInfos, JSON_PRETTY_PRINT);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
   }
}