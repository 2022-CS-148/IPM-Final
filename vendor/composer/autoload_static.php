<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit91b85b4b1be9668470a995bd03e27a96
{
    public static $prefixLengthsPsr4 = array (
        'a' => 
        array (
            'apimatic\\jsonmapper\\' => 20,
        ),
        'S' => 
        array (
            'Square\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'apimatic\\jsonmapper\\' => 
        array (
            0 => __DIR__ . '/..' . '/apimatic/jsonmapper/src',
        ),
        'Square\\' => 
        array (
            0 => __DIR__ . '/..' . '/square/square/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'U' => 
        array (
            'Unirest\\' => 
            array (
                0 => __DIR__ . '/..' . '/apimatic/unirest-php/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit91b85b4b1be9668470a995bd03e27a96::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit91b85b4b1be9668470a995bd03e27a96::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit91b85b4b1be9668470a995bd03e27a96::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit91b85b4b1be9668470a995bd03e27a96::$classMap;

        }, null, ClassLoader::class);
    }
}
