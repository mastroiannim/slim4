<?php
namespace MyApp\Controller;

use Psr\Container\ContainerInterface;
use MyApp\Helper\Session as Session;
use Twig\Environment as Twig;

class IndexAction
{
   protected $container;
   protected $session;
   protected $twig;

   // constructor receives container instance
   public function __construct(ContainerInterface $container, Session $s, Twig $twig) {
       $this->container = $container;
       $this->session = $s;
       $this->twig = $twig;
   }
   
   public function __invoke($request, $response, $args) {
       if($username = $this->session->get('username')){
           $name = ucfirst($username);
           $id = $this->session->get('id');
        }else{
            $name = ucfirst($this->container->get("settings.app")['contact']['name']);
        }
        $response->getBody()->write(
            $this->twig->render('index.twig', [
                'name' => $name,
                'id' => $id
            ])
        );

        return $response;
    }
}