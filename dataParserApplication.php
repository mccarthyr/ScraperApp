<?php

namespace ParserLibrary;

use ParserLibrary\parserContainer;
use ParserLibrary\Parsers\BBCNewsMostPopularParser;

include 'autoloader.php';

/**
 * This has been put here to supress the PHP warnings from the broken 
 * HTML structure from the BBC markup.
 */ 
error_reporting(0);


$parserToCall = NULL;

if (!empty($argv[1])) {
  $parserToCall = strtolower($argv[1]);
} else {
  echo PHP_EOL. 'Please provide one of the application parsers as an argument' .PHP_EOL.PHP_EOL;
  exit;
}


switch( $parserToCall )
{
  case 'bbc':
    $parser = new BBCNewsMostPopularParser();  
  break;
  default:
    echo PHP_EOL. 'The provided parser argument is not recognised' .PHP_EOL.PHP_EOL;
    exit;
}

try 
{

  $parserContainer = new parserContainer( $parser );
  $results = $parserContainer -> parse();

} catch( Exception $e ) {
  echo PHP_EOL .'Unfortunately an error has occured. Please check the application logs'.PHP_EOL;
  // @TODO - Error logging code here using a Logger Component, Monolog is an option.
  exit;
}
  
echo PHP_EOL .' ****** Data Parser Results ****** '.PHP_EOL.PHP_EOL;
echo $results;
  
