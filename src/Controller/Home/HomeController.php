<?php
namespace MyApp\Controller\Home;

use Psr\Container\ContainerInterface;
use Twig\Environment as Twig;

class HomeController
{
   protected $container;
   protected $twig;

   // constructor receives container instance
   public function __construct(ContainerInterface $container, Twig $twig) {
        $this->container = $container;
        $this->twig = $twig;
   }

   public function __invoke($request, $response, $args) {

    $response->getBody()->write( 
        $this->twig->render('home-page.twig', ['name' => "test"])
    );

    return $response;
}

   public function contact($request, $response, $args) {
        // to access items in the container... $this->container->get('');
        $contactInfos = $this->container->get('settings.app')['contact'];
        
        $payload = json_encode($contactInfos, JSON_PRETTY_PRINT);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
   }
}