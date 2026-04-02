<?php

namespace App\Controller;

use Core\View;
use Exception;

class HomeController
{
  public function index(): string
  {
    throw new Exception('This has happened on the web!');
    return View::render(template: 'home/index', data: ['message' => 'Home Page'], layout: 'main');
  }
}
