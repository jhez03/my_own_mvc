<?php

namespace App\Models;

use Core\Model;

class User extends Model
{
  protected static $table = 'users';
  public $id;
  public $name;
  public $email;
  public $password;
  public $role;
  public $created_at;
}
