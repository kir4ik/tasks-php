<?php

use model\Task;

return [
    'tasks' => [
        Task::ID            => 'INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
        Task::CONTENT       => 'TEXT NOT NULL',
        Task::USER_NAME     => 'VARCHAR(50) NOT NULL',
        Task::USER_EMAIL    => 'VARCHAR(100) NOT NULL',
        Task::STATUS        => 'TINYINT(1) NOT NULL DEFAULT 0',
        Task::DATE_CREATED  => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
        Task::DATE_UPDATED  => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
    ]
];