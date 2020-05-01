<?php
namespace MyApp\Controller\Hello;

use Psr\Container\ContainerInterface;
use MyApp\Model\User;
use MyApp\Helper\WriteResponse;
use Illuminate\Database\QueryException;
use Illuminate\Database\Capsule\Manager as Capsule;
use MyApp\Helper\Session as Session;

class HelloController
{
   protected $container;
   protected $session;

   // constructor receives container instance
   public function __construct(ContainerInterface $container, Capsule $db, Session $s) {
       $this->container = $container;
       $this->db = $db;
       $this->session = $s;
   }

   public function put($request, $response, $args) {

      $data = $request->getParsedBody();

      $name = $data['name'];
      $user = new User();
   
      $user->name = $name;
      $user->email = $name . $this->container->get("settings.app")['contact']['email'];

      try{
         $user->save();      
         $response->getBody()->write(json_encode($user, JSON_PRETTY_PRINT));
         $response = $response->withHeader('Content-Type', 'application/json');
         $this->session->set('username', $name);
         $this->session->set('id', $user['id']);
      }catch(QueryException $e){
         $response = WriteResponse::withQueryException($response, $e);
      }
      return $response;
   }

   public function get($request, $response, $args) {
      $id = $args['id'];
      $user = User::find($id);

      $response->getBody()->write(json_encode($user, JSON_PRETTY_PRINT));
      return $response->withHeader('Content-Type', 'application/json');
   }

   public function all($request, $response, $args) {
      // Fetch all users
      $users = User::all();  

      $response->getBody()->write(json_encode($users, JSON_PRETTY_PRINT));
      return $response->withHeader('Content-Type', 'application/json');
   }

}