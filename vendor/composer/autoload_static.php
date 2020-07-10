<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit058215add5ffae9c1b8d4b072b97d5a0
{
    public static $files = array (
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/vendor',
        'a4a119a56e50fbb293281d9a48007e0e' => __DIR__ . '/vendor',
        '72579e7bd17821bb1321b87411366eae' => __DIR__ . '/vendor',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Php80\\' => 23,
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Contracts\\Translation\\' => 30,
            'Symfony\\Component\\Translation\\' => 30,
        ),
        'P' => 
        array (
            'Psr\\SimpleCache\\' => 16,
            'Psr\\Container\\' => 14,
        ),
        'I' => 
        array (
            'Illuminate\\Support\\' => 19,
            'Illuminate\\Database\\' => 20,
            'Illuminate\\Contracts\\' => 21,
            'Illuminate\\Container\\' => 21,
        ),
        'D' => 
        array (
            'Doctrine\\Inflector\\' => 19,
        ),
        'C' => 
        array (
            'Carbon\\' => 7,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Php80\\' => 
        array (
            0 => __DIR__ . '/vendor',
        ),
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/vendor',
        ),
        'Symfony\\Contracts\\Translation\\' => 
        array (
            0 => __DIR__ . '/vendor',
        ),
        'Symfony\\Component\\Translation\\' => 
        array (
            0 => __DIR__ . '/vendor',
        ),
        'Psr\\SimpleCache\\' => 
        array (
            0 => __DIR__ . '/vendor',
        ),
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/vendor',
        ),
        'Illuminate\\Support\\' => 
        array (
            0 => __DIR__ . '/vendor',
        ),
        'Illuminate\\Database\\' => 
        array (
            0 => __DIR__ . '/vendor',
        ),
        'Illuminate\\Contracts\\' => 
        array (
            0 => __DIR__ . '/vendor',
        ),
        'Illuminate\\Container\\' => 
        array (
            0 => __DIR__ . '/vendor',
        ),
        'Doctrine\\Inflector\\' => 
        array (
            0 => __DIR__ . '/vendor',
        ),
        'Carbon\\' => 
        array (
            0 => __DIR__ . '/vendor',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../blog_post',
        ),
    );

    public static $classMap = array (
        'Stringable' => __DIR__ . '/vendor',
        'ValueError' => __DIR__ . '/vendor',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit058215add5ffae9c1b8d4b072b97d5a0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit058215add5ffae9c1b8d4b072b97d5a0::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit058215add5ffae9c1b8d4b072b97d5a0::$classMap;

        }, null, ClassLoader::class);
    }
}
