<?php

namespace App\Models;

use Core\App;
use Core\Model;

class Post extends Model
{
  protected static $table = 'posts';

  public $id;
  public $title;
  public $content;
  public $created_at;
  public $views;
  public $user_id;


  public static function getRecent(int $limit)
  {
    /** @var \Core\Database $db */
    $db = App::get('database');

    return $db->fetchAll(
      "SELECT * FROM " . static::$table . " ORDER BY created_at DESC LIMIT ?",
      [$limit],
      static::class
    );
  }
  public static function incrementViews($id): void
  {
    $db = App::get('database');
    $db->query(
      "UPDATE " . static::$table . " SET views = views + 1 WHERE id = ?",
      [$id]
    );
  }
}
