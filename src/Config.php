<?php

namespace Graphite\Component\Silhouette;

use Graphite\Component\Objectify\Objectify;

class Config extends Objectify
{
    /**
     * Current version of silhouette.
     * 
     * @var string
     */
    private static $version = "v1.0.0";

    /**
     * Supported configuration files.
     * 
     * @var array
     */
    private static $supported = array(
        'php',
        'json',
    );

    /**
     * Configuration file.
     * 
     * @var string
     */
    private $file;

    /**
     * Construct a new config data object.
     * 
     * @param   string $file
     * @param   bool $muted
     * @return  void
     */
    public function __construct(string $file, bool $muted = false)
    {
        $this->file = $file;

        parent::__construct($this->load(), $muted);
    }

    /**
     * Load the configuration file and encapsulate data
     * into data object.
     * 
     * @return array
     */
    private function load()
    {
        if(file_exists($this->file) && is_readable($this->file) && $this->isSupported())
        {
            if($this->extension() == 'php')
            {
                return require $this->file;
            }
            else if($this->extension() == 'json')
            {
                return json_decode($this->file, true);
            }
        }

        return array();
    }

    /**
     * Return configuration file extension.
     * 
     * @return  string
     */
    public function extension()
    {
        return strtolower(pathinfo($this->file, PATHINFO_EXTENSION));
    }

    /**
     * Determine if configuration file is supported.
     * 
     * @return  bool
     */
    public function isSupported()
    {
        return in_array($this->extension(), self::$supported);
    }

    /**
     * Return list of supported configuration files.
     * 
     * @return  array
     */
    public static function getSupportedFiles()
    {
        return self::$supported;
    }

    /**
     * Override objectify's version to silhouette's version.
     * 
     * @return  string
     */
    public static function version()
    {
        return self::$version;
    }
}