<?php
require_once __DIR__ . '/../bootstrap.php';

use Core\App;


$db = App::get('database');

$schemaFile = __DIR__ . '/../database/schema.sql';
$sql = file_get_contents($schemaFile);


try {
  $parts = array_filter(array_map('trim', explode(';', $sql)));

  foreach ($parts as $part) {
    if (!empty($part)) {
      $db->query($part);
    }
  }

  echo "Database schema loaded successfully.\n";
} catch (Exception $e) {
  echo "Error loading database schema: " . $e->getMessage() . "\n";
}
