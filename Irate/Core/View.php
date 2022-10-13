<?php

namespace Irate\Core;

/**
 * View
 */
class View
{
    private static $baseUrl;
    private static $system;
    private static $config;

    // Class constructor
    public function __construct($vars = [])
    {

        if (isset($vars['system'])) {
            self::$system = $vars['system'];
        }

        if (isset($vars['baseUrl'])) {
            self::$baseUrl = $vars['baseUrl'];
        }

        if (isset($vars['config'])) {
            self::$config = $vars['config'];
        }
    }

    // Render a template
    public static function renderTemplate($template, $args = [])
    {
        $baseUrl = self::$baseUrl;
        $assetsUrl = (substr($baseUrl ? $baseUrl : '', -1, -1) === '/' ? $baseUrl . 'assets' : $baseUrl . '/assets');
        $app = self::$system;
        $asset = self::$system::$AssetBundle;
        $security = self::$system::$security;
        $session = self::$system::$session;
        $request = self::$system::$request;
        $libraries = self::$system::$libraries;
        $Html = new \Irate\Helpers\Html();

        // Add each argument passed to the smarty variables.
        foreach ($args as $key => $value) {
            ${$key} = $value;
        }

        ob_start();
        include ROOT_PATH . '/Application/Views/' . $template . '.php';
        $file = ob_get_contents();
        ob_end_clean();

        echo str_replace(array("\r", "\n"), '', $file);
        exit;
    }

    public static function template($template, $args = [])
    {
        ob_start();
        $baseUrl = self::$baseUrl;
        $assetsUrl = (substr($baseUrl ? $baseUrl : '', -1) === '/' ? $baseUrl . 'assets' : $baseUrl . '/assets');
        $app = self::$system;
        $asset = self::$system::$AssetBundle;
        $security = self::$system::$security;
        $session = self::$system::$session;
        $request = self::$system::$request;
        $libraries = self::$system::$libraries;
        $Html = new \Irate\Helpers\Html();

        // Add each argument passed to the smarty variables.
        foreach ($args as $key => $value) {
            ${$key} = $value;
        }

        ob_start();
        include ROOT_PATH . '/Application/Views/' . $template . '.php';
        $file = ob_get_contents();
        ob_end_clean();

        return str_replace(array("\r", "\n"), '', $file);
    }
}