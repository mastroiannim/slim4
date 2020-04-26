<?php
namespace MyApp\Controller\Hello;

use Psr\Container\ContainerInterface;
use MyApp\Model\User;
use MyApp\Helper\WriteResponse;
use Illuminate\Database\QueryException;

class HelloController
{
   protected $container;

   // constructor receives container instance
   public function __construct(ContainerInterface $container) {
       $this->container = $container;
   }

   public function put($request, $response, $args) {

      $data = $request->getParsedBody();

      $name = $data['name'];
      $user = new User();
   
      $user->name = $name;
      $user->email = $name . "@miodominio.com";

      try{
         $user->save();      
         $response->getBody()->write(json_encode($user, JSON_PRETTY_PRINT));
         $response = $response->withHeader('Content-Type', 'application/json');
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