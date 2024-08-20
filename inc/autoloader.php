<?php
spl_autoload_register(function ($class) {
  $namespace = 'SAFW\Plugin\\';

  if (strpos($class, $namespace) !== 0) {
    return;
  }

  $class = str_replace($namespace, '', $class);
  $class = str_replace('\\', DIRECTORY_SEPARATOR, strtolower($class)) . '.class.php';

  $path = SAFW_PLUGIN_DIR . 'includes' . DIRECTORY_SEPARATOR . $class;

  // error_log($path);
  if (file_exists($path)) {
    require_once($path);
  }
});
