<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit146a57bb1c8d7e2713c7de6fa989379f
{
    public static $prefixLengthsPsr4 = array (
        'm' => 
        array (
            'models\\' => 7,
        ),
        'c' => 
        array (
            'controllers\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/models',
        ),
        'controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/controllers',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit146a57bb1c8d7e2713c7de6fa989379f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit146a57bb1c8d7e2713c7de6fa989379f::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit146a57bb1c8d7e2713c7de6fa989379f::$classMap;

        }, null, ClassLoader::class);
    }
}