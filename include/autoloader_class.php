<?php

class ClassAutoloader
{
  public function __construct() {
    spl_autoload_register(array($this, 'loader'));
  }

  public function loader($class_name) {
    $full_path = $root_folder = $parent_folder = $file_extension = '';

    if ($class_name === 'Database') {
      $parent_folder = 'abstract/';
    } elseif (substr($class_name, -10) === 'Controller') {
      $parent_folder = 'controllers/';
    } elseif (substr($class_name, -5) === 'Model') {
      $parent_folder = 'models/';
    } elseif (substr($class_name, -4) === 'View') {
      $parent_folder = 'views/';
    }

    $root_folder = 'classes/';
    $file_extension = '.php';
    $full_path = $root_folder . $parent_folder . $class_name . $file_extension;

    require_once $full_path;
  }
}

$autoloader = new ClassAutoloader();
