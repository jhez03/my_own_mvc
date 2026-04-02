<?php

namespace App\Models;

use Core\App;
use Core\Model;

class Comment extends Model
{
  protected static $table = 'comments';

  public static function forPost($postID): array
  {
    $db = App::get('database');
    return $db->fetchAll(
      "SELECT * FROM " . static::$table . " WHERE post_id = ? ORDER BY created_at DESC",
      [$postID],
      static::class
    );
  }
}
