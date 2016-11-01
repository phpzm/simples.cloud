<?php

define('__SWAGGER_ROOT__', realpath(dirname(dirname(dirname(__DIR__)))));

require_once __SWAGGER_ROOT__ . '/vendor/autoload.php';

swaggering(__SWAGGER_ROOT__);

/**
 * @param $dir
 */
function swaggering($dir)
{
    $composer = json_decode(file_get_contents($dir . '/composer.json'));
    $info = [
        'COMPOSER_NAME' => isset($composer->name) ? $composer->name : null,
        'COMPOSER_DESCRIPTION' => isset($composer->description) ? $composer->description : null,
        'COMPOSER_VERSION' => isset($composer->version) ? $composer->version : '0.0.0',
        'COMPOSER_LICENSE' => isset($composer->license) ? $composer->license : null,
    ];

    $constants = array_filter($info);
    array_map('define', array_keys($constants), $constants);
}
