<?php

namespace ParserLibrary;


interface iParser
{
  public function parse();
  public function formatResults( $informationArray );
}
