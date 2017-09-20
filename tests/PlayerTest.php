<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase {

  public function testAddCardToHand() : void {
    $player = new Player('test');
    $player->addCardToHand(new Card('C', '2'));
    $this->assertEquals(count($player->getHand()), 1);
    $this->assertEquals($player, "test : C2");
  }

  public function testGetHandScore() : void {
    $player = new Player('test');
    $player->addCardToHand(new Card('C', '2'));
    $player->addCardToHand(new Card('C', 'K'));
    $this->assertEquals($player->getScore(), 12);
  }

}