<?php

namespace Graphite\Component\Silhouette;

abstract class Facade extends Config
{
    /**
     * Store config instance.
     * 
     * @var array
     */
    private static $instances = array();

    /**
     * Construct a new configuration facade.
     * 
     * @param   mixed $source
     * @param   bool $muted
     * @return  void
     */
    public function __construct($source, bool $muted = false)
    {
        parent::__construct($source, $muted);
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
        $key        = str_camel_to_kebab($method);
        $value      = $arguments[0] ?? null;
        $config     = self::context();

        if(method_exists($config, $method))
        {
            return $config->{$method}(...$arguments);
        }
        else if($config->has($key))
        {
            if(!is_null($value))
            {
                $config->set($key, $value);

                return $value;
            }
            else
            {
                return $config->{$key};
            }
        }
    }

    /**
     * Return configuration instance.
     * 
     * @return  \Graphite\Component\Silhouette\Config
     */
    public static function context()
    {
        $class  = get_called_class();
        $hash   = md5($class);

        if(!array_key_exists($hash, self::$instances))
        {
            self::$instances[$hash] = new $class();
        }

        return self::$instances[$hash];
    }
}