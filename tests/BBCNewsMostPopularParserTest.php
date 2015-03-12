<?php

namespace ParserLibrary\tests;

//use ParserLibrary\parserContainer;
use ParserLibrary\Parsers\BBCNewsMostPopularParser;

include 'autoloader.php';

class BBCNewsMostPopularParserTest extends \PHPUnit_Framework_Testcase
{

  private $bbcParser;
  private $url = 'http://www.bbc.co.uk/news/';

  protected function setup()
  {
    $this -> bbcParser = new BBCNewsMostPopularParser();
  }

  public function testGetSizeOfLinkedHTMLPage()
  {
    // Assert that we get a string back
    $value = $this -> bbcParser -> getSizeOfLinkedHTMLPage($this -> url);

    // Example return value: "157.41KB"
    $this -> assertInternalType('string', $value);
    $this->assertRegExp('/\d+(KB)/', $value);
  }


  public function testGetMostUsedWordFromPage()
  {
    $exclude = array('the','a','is','I');

    // Assert that we get a string back
    $value = $this -> bbcParser -> getMostUsedWordFromPage($this -> url, $exclude);

    $this -> assertInternalType('string', $value);
    
  }

  public function testParse()
  {
    // This is to supress the warnings from the broken HTML structure in the BBC markup
    error_reporting(0); 
    $results = $this -> bbcParser -> parse();
    
    //var_dump(json_decode($results)); exit;
    /** 
     * When the results are decoded, the object should have a 
     * property called $results which contains an array of objects.
     */ 
    
    $decoded = json_decode($results);
    $this -> assertObjectHasAttribute('results', $decoded);
  }



}

