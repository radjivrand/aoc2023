<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInita2f19b1ea2476937fbd5d2ac5d03f853
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInita2f19b1ea2476937fbd5d2ac5d03f853', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInita2f19b1ea2476937fbd5d2ac5d03f853', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInita2f19b1ea2476937fbd5d2ac5d03f853::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
