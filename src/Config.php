<?php

namespace Graphite\Component\Silhouette;

use Graphite\Component\Objectify\Objectify;

class Config extends Objectify
{
    /**
     * Supported config extensions.
     * 
     * @var array
     */
    private static $supported = array(
        'php',
        'json',
    );

    /**
     * Construct a new config data object.
     * 
     * @param   mixed $source
     * @param   bool $muted
     * @return  void
     */
    public function __construct($source, bool $muted = false)
    {
        parent::__construct(is_array($source) ? $source : ($this->load($source) ?? array()), $muted);
    }

    /**
     * Load the configuration and return as array.
     * 
     * @param   string $filename
     * @return  array
     */
    private function load(string $filename)
    {
        if(file_exists($filename) && is_readable($filename))
        {
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            if($extension == 'php')
            {
                return require_once $filename;
            }
            else if($extension == 'json')
            {
                return json_decode($filename, true);
            }
        }
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
        return 'Silhouette version 1.0.1';
    }
}