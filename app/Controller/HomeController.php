<?php

namespace App\Controller;

use Core\View;
use Exception;

class HomeController
{
  public function index(): string
  {
    throw new Exception("This is a test exception to demonstrate error handling.");
    return View::render(
      template: 'home/index', 
      data: ['message' => 'Home Page'], 
      layout: 'layouts/main'
    );
  }
}
