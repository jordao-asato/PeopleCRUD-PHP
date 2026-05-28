<?php

/**
 * Caminhos de diretório
 */
define('BASEDIR', dirname(__FILE__) .  '/../');
define('VIEWS', dirname(__FILE__) . '/View/modules/');

/**
 * Dados de conexão ao banco de dados
 */
// Environment
$_ENV['db']['host'] = 'localhost:3306';
$_ENV['db']['user'] = 'root';
$_ENV['db']['pass'] = 'jordao123';
$_ENV['db']['database'] = 'db_mvc';
