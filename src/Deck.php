<?php

class Deck {

  private $cards = [];

  public function __construct(string $deckFileName = null) {
    // generate a shuffled deck.
    if (is_null($deckFileName)) {
      foreach (Card::SUITS as $suit) {
        foreach (array_keys(Card::VALUES) as $value) {
          $this->cards[] = new Card($suit, $value);
        }
      }
      shuffle($this->cards);
    } elseif (file_exists($deckFileName)) {
      // create a deck from a file.
      $fileContent = file_get_contents($deckFileName);
      // remove eventual whitespaces 
      $fileContent = str_replace(' ', '', $fileContent);
      $cards = array_reverse(explode(',', $fileContent));
      foreach ($cards as $card) {
        $suit = substr($card, 0, 1);
        $value = substr($card, 1);
        $this->cards[] = new Card($suit, $value);
      }
    }
  }

  // draw a card from the deck
  public function draw() : Card {
    return array_pop($this->cards);    
  }

  // get cards in the deck.
  public function getCards() : array {
    return $this->cards;
  }

}