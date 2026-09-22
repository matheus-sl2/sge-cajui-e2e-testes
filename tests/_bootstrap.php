<?php
/**
 * Bootstrap global dos testes Codeception.
 * Carrega as variáveis de ambiente do arquivo .env, se presente.
 */

require_once __DIR__ . '/../vendor/autoload.php';

if (class_exists(\Dotenv\Dotenv::class)) {
    $rootDir = dirname(__DIR__);
    if (file_exists($rootDir . '/.env')) {
        $dotenv = \Dotenv\Dotenv::createImmutable($rootDir);
        $dotenv->safeLoad();
    }
}
