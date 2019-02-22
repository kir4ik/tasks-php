<?php

return [
    'tasks' => [
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
        'content' => 'TEXT NOT NULL',
        'user_name' => 'VARCHAR(50) NOT NULL',
        'user_email' => 'VARCHAR(100) NOT NULL',
        'date_created' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
        'date_updated' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
    ]
];