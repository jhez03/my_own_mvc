<?php

namespace Core;

use PDO;
use Core\App;

abstract class Model
{
  protected static $table;

  public static function all(): array
  {
    $db = App::get('database');
    return $db->fetchAll(
      "SELECT * FROM " . static::$table,
      [],
      static::class
    );
  }
  public static function find(mixed $id): mixed
  {
    $db = App::get('database');

    return $db->fetch(
      "SELECT * FROM " . static::$table . " WHERE id = ?",
      [$id],
      static::class
    );
  }
  public static function create(array $data): static
  {
    $db = App::get('database');
    // 1) Get tthe names of columns inside data
    $columns = implode(', ', array_keys($data));
    // -> id, title, created_at, content
    $placeholders = implode(', ', array_fill(0, count($data), '?'));
    // -> ?, ?, ?, ?
    $sql = "INSERT INTO " . static::$table . " ($columns) VALUES ($placeholders)";


    $db->query($sql, array_values($data));
    return static::find($db->lastInsertId());
  }

  protected static function createFromArray(array $data): static
  {
    $model = new static();
    foreach ($data as $key => $value) {
      if (property_exists($model, $key)) {
        $model->$key = $value;
      }
    }
    return $model;
  }
}
