<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class DeckTest extends TestCase {

  public function testGeneratesShuffledDeck() : void {
    $deck = new Deck();
    $deckSize = 52;
    $this->assertEquals(count($deck->getCards()), $deckSize);
    $this->assertTrue(is_array($deck->getCards()));
    $this->assertContainsOnlyInstancesOf(Card::class, $deck->getCards());
  }

  public function testGeneratesDeckFromFile() : void {
    $deck = new Deck(__DIR__ . '/deckFiles/DeckTest');
    $this->assertTrue(is_array($deck->getCards()));
    $this->assertContainsOnlyInstancesOf(Card::class, $deck->getCards());
  }

  public function testDrawCardFromDeck() : void {
    $deck = new Deck();
    $deckSizeAfterOneDraw = 51;
    $cardToBeDrawn = $deck->getCards()[51];
    $drawnCard = $deck->draw();
    $this->assertEquals($cardToBeDrawn, $drawnCard);
    $this->assertEquals(count($deck->getCards()), $deckSizeAfterOneDraw);
  }

}