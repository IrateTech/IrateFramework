<?php

namespace Irate\Core;

class Request {

  public function method () {
    return strtolower($_SERVER['REQUEST_METHOD']);
  }

  public function serverName () {
    return $_SERVER['SERVER_NAME'];
  }

  public function url () {
    return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  }

  public function uri () {
    $uri = $_SERVER['REQUEST_URI'];
    $parts = explode('?', $uri);
    return $parts[0];
  }

  public function uriContains ($text) {
    $uri = $this->uri();
    
    return str_contains($uri, $text);
  }

  public function origin () {
    if (array_key_exists('HTTP_REFERER', $_SERVER)) {
        $origin = $_SERVER['HTTP_REFERER'];
    } else {
        $origin = $_SERVER['REMOTE_ADDR'];
    }

    return $origin;
  }

  /**
   * Requires a specific REQUEST_METHOD for an
   * action.
   */
  public function requireMethod($method = 'get') {
    $method = strtoupper($method);

    if ($_SERVER['REQUEST_METHOD'] !== $method) {
      throw new \Exception('Required request method does not match.');
    }
  }

  /**
   * Require a GET or POST variable.
   */
  public function require($type = 'get', $var = null, $return = 'exception') {
    if (is_null($var)) return false;

    if (is_array($var)) {
      foreach ($var as $v) {
        if (!$this->$type($v)) {
          if ($return === 'exception') throw new \Exception('Required parameter not provided.');
          else return false;
        }
      }
    } else {
      if (!$this->$type($var)) {
        if ($return === 'exception') throw new \Exception('Required parameter not provided.');
        else return false;
      }
    }

    return true;
  }

  // Retrieve get variables
  public function get($key = null) {
    if (is_null($key)) return $_GET;
    if (isset($_GET[$key])) {
      return $_GET[$key];
    } else {
      return false;
    }
  }

  // Retrieve POST variables
  public function post($key = null) {
    $post = \Irate\Core\Utilities::getPost();

    if (is_null($key)) return $post;
    if (isset($post[$key])) {
      return $post[$key];
    } else {
      return false;
    }
  }

  public function clientIp() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
      $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
      $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
      $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
      $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
      $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
      $ipaddress = getenv('REMOTE_ADDR');
    else
      $ipaddress = 'UNKNOWN';
    return $ipaddress;
  }

  // Retrieve a specific header
  public function header ($key) {
    $headers = $this->headers();

    foreach ($headers as $name => $value) {
      if ($name === $key) return $value;
    }

    return false;
  }

  // Get all headers
  public function headers () {
    if (!function_exists('getallheaders')) {
      $headers = '';

      foreach ($_SERVER as $name => $value) {
        if (substr($name, 0, 5) == 'HTTP_') {
          $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
        }
      }

      return $headers;
    }

    return getallheaders();
  }
}