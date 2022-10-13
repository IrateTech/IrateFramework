<?php

namespace Irate\Core;

use \PDO;

class Connection {

  public $client = null;
  public $connection = false;
  private $config = false;

  public function __construct($vars = []) {

    if (isset($vars['config'])) {
      $this->config = $vars['config'];
    }

    if (!isset($this->config->DB_HOST) ||
        !isset($this->config->DB_NAME) ||
        !isset($this->config->DB_USER) ||
        !isset($this->config->DB_PASSWORD)) {
      error_log('One of the DB_ constants are missing. Skipping Database Connection.');
      return false;
    }

    if (!$this->config->DB_HOST) return false;
    if (empty($this->config->DB_HOST)) return false;
    $this->instantiate();
  }

  /**
   * Instantiates a PDO Connection based on the
   * Application\Config DB_* variables
   */
  private function instantiate() {

    $config = [
    	'host'		  => $this->config->DB_HOST,
    	'driver'	  => (isset($this->config->DB_DRIVER) ? $this->config->DB_DRIVER : 'mysql'),
    	'database'	=> $this->config->DB_NAME,
    	'username'	=> $this->config->DB_USER,
    	'password'	=> $this->config->DB_PASSWORD,
    	'charset'	  => (isset($this->config->DB_CHARSET) ? $this->config->DB_CHARSET : 'utf8'),
    	'collation'	=> (isset($this->config->DB_COLLATION) ? $this->config->DB_COLLATION : 'utf8_general_ci'),
    	'prefix'	  => (isset($this->config->DB_PREFIX) ? $this->config->DB_PREFIX : '')
    ];
    if (isset($this->config->DB_SSL)) {
      $config['opts'] = [
        PDO::MYSQL_ATTR_SSL_CA => $this->config->DB_SSL,
	      PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
      ];
    }

    try {
      $this->client = new \Buki\Pdox($config);
      $this->connection = true;
    } catch (\Exception $e) {
      throw new \Exception('[MySQL Error]: ' . $e->getMessage());
    }

    return true;
  }
}
