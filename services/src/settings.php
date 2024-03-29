<?php

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::INFO,
            'maxFiles' => 90
        ],
        'db' => [
            'driver' => 'sqlsrv',
            'host' => '203.151.210.199',//'LAPTOP-LL92CALS\SQLEXPRESS',//'54.169.84.115',
            'database' => 'ExamSystem',//'Exam System',
            'username' => 'sa',//'exam',//'saExam',
            'password' => '8*yKjSV2',//exam#123',//'p0o9i8u7y6',
        ]
    ],
];
