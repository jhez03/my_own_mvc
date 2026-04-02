<?php

namespace App\Controller;

class PostController
{
  public function index(): string
  {
    return 'This is the Post Page!';
  }

  public function show(array $params): string
  {
    return "Showing post with ID: " . $params['id'];
  }
}
