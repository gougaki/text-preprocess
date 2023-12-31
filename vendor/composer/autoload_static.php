<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2de3e514781d2b36d49ffb208589aa1c
{
    public static $prefixesPsr0 = array (
        'S' => 
        array (
            'Sastrawi\\' => 
            array (
                0 => __DIR__ . '/..' . '/sastrawi/sastrawi/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit2de3e514781d2b36d49ffb208589aa1c::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit2de3e514781d2b36d49ffb208589aa1c::$classMap;

        }, null, ClassLoader::class);
    }
}
