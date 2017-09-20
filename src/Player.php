<?php

class Player {

  private $hand;

  public function __construct(string $name) {
    $this->name = $name;
    $this->hand = [];
  }

  public function getScore() : int {
    return array_reduce($this->hand, function ($score, $card) {
      $score += $card->getValue();
      return $score;
    });
  }

  public function getHand() : array {
    return $this->hand;
  }
  
  public function addCardToHand(Card $card) : void {
    $this->hand[] = $card;
  }

  public function getName() : string {
    return $this->name;
  }

  public function __toString() : string {
    return $this->getName() . ' : ' . implode(', ', $this->hand); 
  }

}