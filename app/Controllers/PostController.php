<?php

namespace App\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Core\Router;
use Core\View;

class PostController
{
  public function index(array $params = []): string
  {
    $posts = Post::getRecent(5);
    return View::render(
      template: 'posts/index',
      data: ['posts' => $posts],
      layout: 'layouts/main'
    );
  }

  public function show(array $params)
  {
    $id = $params['id'];
    $post = Post::find($id);

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
