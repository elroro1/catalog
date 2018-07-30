<?php

/*
------------------------------------------
Use:
php console.php [OPTIONS]

OPTIONS:
 -f, --file      Filename (with path) to treat


Example:
 php console.php --file=xml/825646618309.xml
------------------------------------------
*/

//~ Report & Display all error
error_reporting(-1);
ini_set('display_errors', true);

//~ Set time limit to 10s
set_time_limit(10);

echo '>>> TEST CATALOG SCRIPT <<<', PHP_EOL;

$time = microtime(true);

//~ Preparse script arguments
require_once 'classes/Argument.php';
require_once 'classes/ArgumentIterator.php';
require_once 'classes/ParserInterface.php';
require_once 'classes/ParserXMLDDEX341.php';
require_once 'classes/Reconciler.php';


$arguments = \Deezer\Component\Console\Argument::getInstance();
$arguments->parse($argv);

//~ Example of use for class Argument
//~ Argument::get({SHORT_NAME}, {LONG_NAME}, [{DEFAULT_VALUE}]);
//~ $file = $arguments->get('f', 'file', 'xml/825646618309.xml');


// ------------------------------------------

$file = __DIR__ . '/' . $arguments->get('f', 'file', 'xml/825646618309.xml');
echo 'Process file: ' . $file . PHP_EOL;

// YOUR CODE HERE
/**
 * TODO Faire une factory pour trouver le bon fichier parser ( par exemple en cas de format/langue/version différents)
 */

echo("parse file \n");
$parser = new \Deezer\Utils\ParserXMLDDEX341();
$entities = $parser->parse($file);
$reconcilier = new \Deezer\Utils\Reconciler();
$reconcilier->processData($entities);


// ------------------------------------------

echo '>>> END SCRIPT - Time: ', round((microtime(true) - $time), 2), 's <<<', PHP_EOL;


