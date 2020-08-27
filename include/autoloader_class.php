<?php

class ClassAutoloader
{

  public function __construct() {
    spl_autoload_register(array($this, 'loader'));
  }

  public function loader($class_name) {
    $full_path = $root_folder = $parent_folder = $file_extension = '';
    $class_name = strtolower($class_name);
    $file_name = $class_name . 's';

    if ($class_name === 'db') {
      $parent_folder = 'abstract/';
      $file_name = $class_name;
    } elseif ($class_name === 'controller') {
      $parent_folder = 'controllers/';
    } elseif ($class_name === 'model') {
      $parent_folder = 'models/';
    } elseif ($class_name === 'view') {
      $parent_folder = 'views/';
    }

    $root_folder = 'classes/';
    $file_extension = '.php';
    $full_path = $root_folder . $parent_folder . $file_name . $file_extension;

    require_once $full_path;
  }
}

$autoloader = new ClassAutoloader();
