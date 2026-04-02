<?php

namespace Core;

class View
{
  public static function render(string $template, array $data = [], string $layout = null): string
  {
    $content = static::renderTemplate(
      $template,
      $data
    );
    return static::renderLayout(
      $layout,
      $data,
      $content
    );
  }

  protected static function renderTemplate(string $template, array $data): string
  {
    extract($data);
    $path = dirname(__DIR__) . '/app/View/' . $template . '.php';

    if (!file_exists($path)) {
      throw new \Exception("Template not found: $template");
    }

    ob_start();
    require $path;
    return ob_get_clean();
  }

  protected static function renderLayout(string $template, array $data, string $content): string
  {
    if (null === $template) {
      return $content;
    }
    extract([...$data, 'content' => $content]);
    $path = dirname(__DIR__) . '/app/View/' . $template . '.php';


    if (!file_exists($path)) {
      return 'not found';
    }

    ob_start();
    require $path;
    return ob_get_clean();
  }
}
