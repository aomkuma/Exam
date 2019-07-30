<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    $logger->pushHandler(new Monolog\Handler\RotatingFileHandler($settings['path'], $settings['maxFiles'], $settings['level']));
    return $logger;
};

$container['db'] = function ($c) {
    $settings = $c->get('settings')['db'];
    $capsule = new Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($settings);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    return $capsule;
};

$container['LoginController'] = function ($c) {
    return new \App\Controller\LoginController($c->get('logger'), $c->get('db'));
};

$container['UserController'] = function ($c) {
    return new \App\Controller\UserController($c->get('logger'), $c->get('db'));
};

$container['BankController'] = function ($c) {
    return new \App\Controller\BankController($c->get('logger'), $c->get('db'));
};

$container['SubjectController'] = function ($c) {
    return new \App\Controller\SubjectController($c->get('logger'), $c->get('db'));
};

$container['LevelController'] = function ($c) {
    return new \App\Controller\LevelController($c->get('logger'), $c->get('db'));
};

$container['ExamSourceController'] = function ($c) {
    return new \App\Controller\ExamSourceController($c->get('logger'), $c->get('db'));
};

$container['ChapterController'] = function ($c) {
    return new \App\Controller\ChapterController($c->get('logger'), $c->get('db'));
};

$container['TopicController'] = function ($c) {
    return new \App\Controller\TopicController($c->get('logger'), $c->get('db'));
};

$container['ExamSetController'] = function ($c) {
    return new \App\Controller\ExamSetController($c->get('logger'), $c->get('db'));
};

$container['QuestionController'] = function ($c) {
    return new \App\Controller\QuestionController($c->get('logger'), $c->get('db'));
};


