<?php
class Db {
  private static $instance = NULL;

  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = mysqli_connect("localhost", "root", "", "vaja1");
      self::$instance->set_charset("UTF8");
    }

    return self::$instance;
  }
}