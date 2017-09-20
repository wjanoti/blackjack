<?php

class Card {

  const SUITS = [ 'C', 'D', 'H', 'S' ];

  const VALUES = [
    'A' => 11,
    '2' => 2,
    '3' => 3,
    '4' => 4,
    '5' => 5,
    '6' => 6,
    '7' => 7,
    '8' => 8,
    '9' => 9,
    '10' => 10,
    'J' => 10,
    'Q' => 10,
    'K' => 10
  ];
  
  private $suit;
  private $value;

  public function __construct(string $suit, string $value) {
    $this->suit = $suit;
    $this->value = $value;
  }

  public function __toString() : string {
    return $this->suit . $this->value;
  }

  public function getValue() : int {
    return self::VALUES[$this->value];
  }

}