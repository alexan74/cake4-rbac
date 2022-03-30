<?php
$baseDir = dirname(dirname(__FILE__));

return [
    'plugins' => [
        'Admin' => $baseDir . '/plugins/Admin/',
        'AdminLTE' => $baseDir . '/plugins/AdminLTE/',
        'AdminLTE2' => $baseDir . '/plugins/AdminLTE2/',
        'Bake' => $baseDir . '/vendor/cakephp/bake/',
        'Cake/TwigView' => $baseDir . '/vendor/cakephp/twig-view/',
        'DebugKit' => $baseDir . '/vendor/cakephp/debug_kit/',
        'Migrations' => $baseDir . '/vendor/cakephp/migrations/',
        'Rbac' => $baseDir . '/plugins/Rbac/',
    ],
];
