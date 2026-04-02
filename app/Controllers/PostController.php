<?php

namespace App\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Core\Router;
use Core\View;

class PostController
{
  public function index(): string
  {
    return 'This is the Post Page!';
  }

  public function show($id)
  {
    $post = Post::find($id);

    echo '<pre>';
    print_r($post);
    exit;
    if (!$post) {
      Router::notFound();
    }

    $comments = Comment::forPost($id);
    Post::incrementViews($id);

    return View::render(
      template: 'posts/show',
      data: ['post' => $post, 'comments' => $comments],
      layout: 'layouts/main'
    );
  }
}
