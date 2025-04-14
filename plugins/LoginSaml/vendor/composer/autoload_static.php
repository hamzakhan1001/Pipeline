<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitp99263c668419dee266a5b986f5f27eb2
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'RobRichards\\XMLSecLibs\\' => 23,
        ),
        'O' => 
        array (
            'OneLogin\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'RobRichards\\XMLSecLibs\\' => 
        array (
            0 => __DIR__ . '/..' . '/robrichards/xmlseclibs/src',
        ),
        'OneLogin\\' => 
        array (
            0 => __DIR__ . '/..' . '/onelogin/php-saml/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitp99263c668419dee266a5b986f5f27eb2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitp99263c668419dee266a5b986f5f27eb2::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitp99263c668419dee266a5b986f5f27eb2::$classMap;

        }, null, ClassLoader::class);
    }
}
