<?php

namespace Graphite\Component\Silhouette;

abstract class Facade extends Config
{
    /**
     * Store config instance.
     * 
     * @var \Graphite\Component\Silhouette\Config
     */
    private static $instance;

    /**
     * Construct a new configuration facade.
     * 
     * @param   string $file
     * @param   bool $muted
     * @return  void
     */
    public function __construct(string $file, bool $muted = false)
    {
        parent::__construct($file, $muted);
    }

    /**
     * Return configuration data statically.
     * 
     * @param   string $method
     * @param   array $arguments
     * @return  mixed
     */
    public static function __callStatic(string $method, array $arguments)
    {
        $key        = str_camel_to_snake($method);
        $config     = self::context();

        if(method_exists($config, $method))
        {
            return $config->{$method}(...$arguments);
        }
        else if($config->has($key))
        {
            return $config->{$key};
        }
    }

    /**
     * Return configuration instance.
     * 
     * @return  \Graphite\Component\Silhouette\Config
     */
    public static function context()
    {
        $class = get_called_class();

        if(is_null(self::$instance))
        {
            self::$instance = new $class();
        }

        return self::$instance;
    }
}