<?php

namespace Irate\Core;

class Crons {

  private $instance = null;

  public function __construct ($instance) {
    $this->instance = $instance;
  }

  public function log ($data, $label = null) {

    // Convert array or object to JSON
    if (is_array($data) || is_object($data)) $data = json_encode($data);

    // Format the label and the date
    $label = (!is_null($label) ? "[$label]" : "");
    $date  = date("m.d.y G:i:s");

    // Construct the log
    $log = "{$label}[{$date}]: {$data}\r\n";

    echo $log . PHP_EOL;
  }

  public function run ($path) {
    $fileExtension = '.php';

    if (strpos($path, $fileExtension) === false) $path .= $fileExtension;

    $filePath = ROOT_PATH . '/Application/Crons/' . $path;

    if (!file_exists($filePath)) {
      throw new \Exception('Cron does not exist.');
    }

    $function = require $filePath;

    if (!is_callable($function)) {
      throw new \Exception('Cron is not formatted and returned as a function.');
    }

    $function($this->instance);
  }
}
