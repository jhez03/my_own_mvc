<?php

namespace Core;

class ErrorHandler
{
  public static function handleException(\Throwable $exception)
  {
    //1. Log the error
    static::logError($exception);


    if (php_sapi_name() == 'cli') {
      static::renderCliError($exception);
    } else {
      static::renderErrorPage($exception);
    }
  }


  private static function renderErrorPage(\Throwable $exception): void
  {
    $isDebug = App::get('config')['app']['debug'] ?? false;

    if ($isDebug) {
      $errorMessage = self::formatErrorMessage($exception, "<h1>[%s] Error: %s: %s in %s on line %d</h1>");
      $trace = $exception->getTraceAsString();
    } else {
      $errorMessage = "<h1>[%s] An unexpected error occurred. Please check the error log for details.</h1>";
      $trace = '';
    }

    http_response_code(500);
    echo View::render('errors/500', [
      'errorMessage' => $errorMessage,
      'trace' => $trace,
      'isDebug' => $isDebug

    ], 'layouts/main');
    exit(1);
  }

  private static function renderCliError(\Throwable $exception): void
  {
    $isDebug = App::get('config')['app']['debug'] ?? false;

    if ($isDebug) {
      $errorMessage = self::formatErrorMessage($exception, "\033[31m[%s] Error: \033[0m %s: %s in %s on line %d\n");
      $trace = $exception->getTraceAsString();
    } else {
      $errorMessage = "\033[31m[%s] unexpected error occurred. Please check error lof for details: \033[0m\n";
      $trace = '';
    }

    fwrite(STDERR, $errorMessage);
    if ($trace) {
      fwrite(STDERR, "\nStack trace:\n" . $trace . "\n");
    }
    exit(1);
  }
  private static function logError(\Throwable $exception): void
  {
    $logMessage = static::formatErrorMessage(
      $exception,
      "[%s] Error: %s: %s in %s on line %d\n"
    );
    error_log($logMessage, 3, __DIR__ . '/../logs/error.log');
  }

  public static function handleError($level, $message, $file, $line)
  {
    $exception = new \ErrorException($message, 0, $level, $file, $line);
    self::handleException($exception);
  }

  private static function formatErrorMessage(\Throwable $exception, string $format): string
  {
    return sprintf(
      $format,
      date('Y-m-d H:i:s'),
      get_class($exception),
      $exception->getMessage(),
      $exception->getFile(),
      $exception->getLine()

    );
  }
}
