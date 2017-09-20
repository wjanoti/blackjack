<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class CardTest extends TestCase {

  public function testCardValue() : void {
    $card = new Card('C', 'A');
    $this->assertEquals($card->getValue(), 11);
  }

  public function testPrintCard() : void {
    $card = new Card('C', '2');
    $this->assertEquals($card, 'C2');
  }

}