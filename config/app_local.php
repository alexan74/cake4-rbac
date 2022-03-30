<?php
/*
 * Local configuration file to provide any overrides to your app.php configuration.
 * Copy and save this file as app_local.php and make changes as required.
 * Note: It is not recommended to commit files with credentials such as app_local.php
 * into source code version control.
 */
return [
    /*
     * Debug Level:
     *
     * Production Mode:
     * false: No error messages, errors, or warnings shown.
     *
     * Development Mode:
     * true: Errors and warnings shown.
     */
    'debug' => filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),
    'app'=> [
        'fullBaseUrl'=>$_SERVER['SERVER_NAME']
    ],
    'params' => [
        'aplicacion' => 'DITIC',  //titulo de aplicacion para correos
        'ldap' => [
            'hostname' => 'ldap.mrec.ar',
            'base' => 'dc=mrec,dc=ar'
        ],
        'idiomas' => [  // IDIOMAS_ADICIONALES
            'en' => 'Ingles'
        ],
        'captcha' => [
            'sitekey' => '6LejZSsUAAAAAPpcTyFapQcmgZwLJQSvtRw-ZLyR'
        ],
        'pass_login_externo' => 'http://'.$_SERVER['SERVER_NAME']
    ],
    // CONFIGURACION DEL TEMPLATE
    'Tema' => [
        'titulo' => 'TituloApp',  // Titulo del sistema
        'logo' => [
            'mini' => '<b>A</b>dmin',
            'large' => '<b>Administración</b>'
        ],
        'folder' => ROOT,
        'skin' => 'blue'
    ],
    // CONFIGURACION DE LA SEGURIDAD
    'Security' => [
        'salt' => env('SECURITY_SALT', '419cf1677f111daf8b0ce76d8ec1f40897684c8188b861a35cf268415523e62a'),
    ],
    // DATOS DE CONEXION DE LA BD
    'Datasources' => [
        'default' => [
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'database' => 'cake4_rbac',
            'log' => true,
            'encoding' => 'utf8',
            'timezone' => 'UTC',
        ],
        /*'default' => [
         'host' => 'mreldb04.mrec.ar',
         'port' => '3309',
         'username' => 'trigrama_tjg',
         'password' => '4893reuid',
         'database' => 'cake24_becas_desa',
         'log' => true,
         'encoding' => 'utf8',
         'timezone' => 'UTC',
         ]*/
    ],
    // CONFIGURACION DE EMAIL
    'EmailTransport' => [
        /*'default' => [
         'className' => 'Mail',  // Smtp
         'host' => 'localhost',
         'port' => 25,
         'timeout' => 30,
         'username' => null,
         'password' => null,
         'client' => null,
         'tls' => null,
         ],*/
        /*'default' => [
            'className' => 'Smtp',
            'port'=>'465', // 465 en prod
            'host' => 'ssl://smtp.mrecic.gov.ar',
            'username'=>'pruebas_aplicaciones@mrecic.gov.ar',
            'password'=>'Pru3b4s4plic4cion3s', 'transport' => 'Smtp',
            'timeout'=>'30', 'tls' => false,
            'client' => 'MREC test mailer',
            'charset' => 'utf-8',
            'headerCharset' => 'utf-8'
        ],*/
        'default' => [
            'className' => 'Smtp',
            'port'=>'465',
            'host' => 'ssl://smtp.mrecic.gov.ar',
            'username'=>'rbac@mrecic.gov.ar',
            'password'=>'cl4v3rb4c',
            'transport' => 'Mail',
            'timeout'=>'30',
            'tls' => false,
            'context' => [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                   ]
            ],
            'client' => 'MREC mailer',
            'charset' => 'utf-8',
            'headerCharset' => 'utf-8',
            'log'=>true
        ]
    ],
    'Email' => [
        'default' => [
            'transport' => 'default',
            'from'=>'rbac@mrecic.gov.ar',
        ],
    ],
];

