<?php

namespace ParserLibrary\Parsers;

use ParserLibrary\iParser;


class BBCNewsMostPopularParser implements iParser
{

  private static $url = 'http://www.bbc.co.uk/news/';
  // (excluding the, a, is, and or I)
  private static $exclude = array('the','a','is','I');
  
  /**
   * This gets the webpage contents and loads it into a
   * DOM structure which can then be parsed.
   * This method is specific to the BBC News Most Popular section for
   * scraping links from there.
   * 
   * @return JSON structure containing the parsed formatted results.
   */ 
  public function parse()
  {

    $data = file_get_contents(static::$url);
    $dom = new \DOMDocument();
    $dom->loadHTML($data);
    $dom -> preserveWhiteSpace = false;

    $htmlSection = $dom -> getElementById("most-popular");

    $olTags = $htmlSection->getElementsByTagName('ol');  // This returns a DOMNodeList

    $liTags = $olTags -> item(0) -> childNodes; // DOMNodeList


    $informationArray = array();
    $i = 0;
    foreach($liTags as $liTag)
    {
      if ($liTag -> nodeName == '#text') {
	// Ignoring these type of nodes.
	continue;
      }
  
      $liTagChildren = $liTag -> childNodes;

      // Extracting the href link details.
      $links = $liTagChildren -> item(1) -> attributes;
      $hyperLinkRef = $links-> getNamedItem('href') -> value;


      // Follow the link to get the size of the page
      $linkSize = $this -> getSizeOfLinkedHTMLPage( $hyperLinkRef );
      
      // Get the most used word count from that page
      $mostUsedWord = $this -> getMostUsedWordFromPage( $hyperLinkRef, static::$exclude );
      
      $aTagChildren = $liTagChildren -> item(1) -> childNodes; // DOMNodeList
      
      // This is specifically indexed to access the link text detail.
      $linkText = $aTagChildren -> item(2) -> nodeValue;

      $informationArray[$i]['title'] = $linkText; 
      $informationArray[$i]['href'] = $hyperLinkRef;
      $informationArray[$i]['size'] = $linkSize;
      $informationArray[$i]['most_used_word'] = $mostUsedWord;

      $i++;
    }

    return $this -> formatResults( $informationArray );
  }


  /**
   * @param array $informationArray
   * Takes an array and associated it to a 'results' key
   * within an outer array and then encodes it in JSON.
   * 
   * @return string $jsonFormattedResults - JSON string
   */  
  public function formatResults( $informationArray )
  {
    $results = array('results' => $informationArray);
    $jsonFormattedResults = json_encode($results);
    return $jsonFormattedResults;
  }


  /**
   * @param  string $url
   * @return string $size - represents the size of the page in KB
   * 
   * @TODO - Put in URL format check and exception throwing code. Exception
   *         tests can then be run also.
   */ 
  public function getSizeOfLinkedHTMLPage( $url )
  {
    $headers = get_headers($url, 1);
    $content_length = (int)$headers["Content-Length"];
    $size = round( $content_length/1024, 2 ) .'KB';
    return $size;
  }


  /**
   * @param string $url
   * @param array  $exclude (Optional) - array of words to ignore
   * 
   * @return string $mostUsedWord
   * 
   * @TODO - Put in URL format check and exception throwing code. Exception
   *         tests can then be run also.
   */ 
  public function getMostUsedWordFromPage( $url, $exclude = NULL )
  {
    $data = file_get_contents($url);

    // Convert the content into an array of key word value associated to their frequency value
    $wordArray =  str_word_count(strip_tags(strtolower(html_entity_decode($data))),1);

    if ( !is_null($exclude) && is_array($exclude) ) {
      // Remove the excluded words
      $wordArray = array_diff($wordArray, $exclude);
    }

    $highestValue = max(array_count_values($wordArray));
    // Get the key that is the word representing the highest frequency
    $mostUsedWord = array_search($highestValue,array_count_values($wordArray) );
    return $mostUsedWord;
  }
}



