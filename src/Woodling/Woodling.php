<?php namespace Woodling;

/**
 * Woodling facade
 */

class Woodling
{

    /**
     * @var Core
     */
    protected static $core;

    /**
     * @return Core
     */
    public static function init()
    {
        $core = new Core();
        $core->finder->findBlueprints();
        return $core;
    }

    public static function reset()
    {
        self::$core = NULL;
    }

    public static function core(Core $core = NULL)
    {
        if ($core)
        {
            self::$core = $core;
        }

        else if (self::$core === NULL)
        {
            self::$core = self::init();
        }

        return self::$core;
    }

    /**
     * Creates a new blueprint and stores it in repository.
     * 
     * @param string $className
     * @param \Closure|array $params
     */
    public static function seed($className, $params)
    {
        static::core()->seed($className, $params);
    }

    /**
     * Returns an instance of your class with attributes defined in blueprint.
     * 
     * @param string $className
     * @param array $attributeOverrides
     * @return object
     */
    public static function retrieve($className, $attributeOverrides = array())
    {
        return static::core()->retrieve($className, $attributeOverrides);
    }

    /**
     * Returns a saved instance of your class with attributes defined in blueprint.
     * 
     * @param string $className
     * @param array $attributeOverrides
     * @return object
     */
    public static function saved($className, $attributeOverrides = array())
    {
        return static::core()->saved($className, $attributeOverrides);
    }

    /**
     * Returns an array of your class instances.
     * 
     * @param string $className
     * @param int $count
     * @param array $attributeOverrides
     * @return array
     */
    public static function retrieveList($className, $count, $attributeOverrides = array())
    {
        return static::core()->retrieveList($className, $count, $attributeOverrides);
    }

    /**
     * Returns an array of your class' saved instances
     * 
     * @param string $className
     * @param int $count
     * @param array $attributeOverrides
     * @return array
     */
    public static function savedList($className, $count, $attributeOverrides = array())
    {
        return static::core()->savedList($className, $count, $attributeOverrides);
    }

}
