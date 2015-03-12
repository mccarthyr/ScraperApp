<?php

namespace ParserLibrary;

class parserContainer
{

  private $_parserStrategy = NULL;
  
  public function __construct(iParser $parserStrategy)
  {
      $this -> _parserStrategy = $parserStrategy;
  }

  public function parse()
  {
    $results = $this -> _parserStrategy -> parse();
    return $results;
  }




}
