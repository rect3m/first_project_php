<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita9ef93ef8b2f8e3737a003cc56760336
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita9ef93ef8b2f8e3737a003cc56760336::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita9ef93ef8b2f8e3737a003cc56760336::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita9ef93ef8b2f8e3737a003cc56760336::$classMap;

        }, null, ClassLoader::class);
    }
}