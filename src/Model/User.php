<?php
namespace MyApp\Model;

use Illuminate\Database\Eloquent\Model; 

class User extends Model { 

    protected $primaryKey = 'id';
    protected $table= 'users'; 
    protected $fillable = ['name','email'];

}