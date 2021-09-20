<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2c7bd27d9cd9551fff04cdc6a6ac8a89
{
    public static $prefixLengthsPsr4 = array (
        's' => 
        array (
            'setasign\\Fpdi\\' => 14,
        ),
        'i' => 
        array (
            'iio\\libmergepdf\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'setasign\\Fpdi\\' => 
        array (
            0 => __DIR__ . '/..' . '/setasign/fpdi/src',
        ),
        'iio\\libmergepdf\\' => 
        array (
            0 => __DIR__ . '/..' . '/iio/libmergepdf/src',
        ),
    );

    public static $classMap = array (
        'FPDF' => __DIR__ . '/..' . '/setasign/fpdf/fpdf.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2c7bd27d9cd9551fff04cdc6a6ac8a89::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2c7bd27d9cd9551fff04cdc6a6ac8a89::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2c7bd27d9cd9551fff04cdc6a6ac8a89::$classMap;

        }, null, ClassLoader::class);
    }
}