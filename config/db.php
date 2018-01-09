<?php

return [
    'class' => 'yii\db\Connection',
    'masters' => [ //主库列表  配置单项
        ['dsn' => 'mysql:host=localhost;dbname=soocadv'],
    ],
    'masterConfig' => [ //主库通用配置
        'username' => 'root',
        'password' => 'haiyan.com',
        'charset' => 'utf8mb4',
//                'tablePrefix' => 'ge_',
        'attributes' => [
            PDO::ATTR_TIMEOUT => 10
        ]
    ],
    'slaves' => [ //从库列表  配置单项
        ['dsn' => 'mysql:host=localhost;dbname=soocadv'],
    ],
    'slaveConfig' => [ //从库通用配置
        'username' => 'root',
        'password' => 'haiyan.com',
        'charset' => 'utf8mb4',
//                'tablePrefix' => 'ge_',
        'attributes' => [
            PDO::ATTR_TIMEOUT => 10
        ]
    ],
    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
