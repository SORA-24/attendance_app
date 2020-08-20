<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    public function __construct()
  {
    $this->middleware('auth:admin');
  }
   protected $fillable = [
       'name',  'password', 'belong_id'
   ];

   protected $hidden = [
       'password', 'remember_token',
   ];
}

