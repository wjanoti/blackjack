<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class GameTest extends TestCase {

  private $sam;
  private $dealer;
  private $game;

  public function setUp() {
    $this->sam = new Player('Sam');
    $this->dealer = new Player('Dealer');
    $this->game = new Game();
  }

  public function testBlackjack() : void {
    $deck = new Deck(__DIR__ . '/deckFiles/GameTestDeckBlackjack');
    $this->game->addDeck($deck);
    $this->game->addPlayers([ $this->sam, $this->dealer ]);
    $this->game->start();
    $this->assertEquals($this->game->getWinner(), $this->sam);
  }

  public function testSamWinsWhenBothBlackjack() : void {
    $deck = new Deck(__DIR__ . '/deckFiles/GameTestDeckBothPlayersBlackjack');
    $this->game->addDeck($deck);
    $this->game->addPlayers([ $this->sam, $this->dealer ]);
    $this->game->start();
    $this->assertEquals($this->sam->getScore(), 21);
    $this->assertEquals($this->dealer->getScore(), 21);
    $this->assertEquals($this->game->getWinner(), $this->sam);
  }

  public function testDealerWinsWhenBothGet22() : void {
    $deck = new Deck(__DIR__ . '/deckFiles/GameTestDeckBothPlayers22');
    $this->game->addDeck($deck);
    $this->game->addPlayers([ $this->sam, $this->dealer ]);
    $this->game->start();
    $this->assertEquals($this->sam->getScore(), 22);
    $this->assertEquals($this->dealer->getScore(), 22);
    $this->assertEquals($this->game->getWinner(), $this->dealer);
  }

  public function testSamStopsDrawingWhenScoreIs17OrHigher() {
    $deck = new Deck(__DIR__ . '/deckFiles/GameTestDeckSamStopsWhen17OrHigher');
    $this->game->addDeck($deck);
    $this->game->addPlayers([ $this->sam, $this->dealer ]);
    $this->game->start();
    $this->assertEquals($this->sam->getScore(), 17);
  }

  public function testPlayerLosesWhenTotalHigherThan21() {
    $deck = new Deck(__DIR__ . '/deckFiles/GameTestDeckPlayerLosesWhenHigher21');
    $this->game->addDeck($deck);
    $this->game->addPlayers([ $this->sam, $this->dealer ]);
    $this->game->start();
    $this->assertEquals($this->sam->getScore(), 24);
    $this->assertEquals($this->game->getWinner(), $this->dealer);
  }

  public function testDealerStopsDrawingWhenScoreHigherThanSam() {
    $deck = new Deck(__DIR__ . '/deckFiles/GameTestDealerStopsDrawingWhenScoreHigherThanSam');
    $this->game->addDeck($deck);
    $this->game->addPlayers([ $this->sam, $this->dealer ]);
    $this->game->start();
    $this->assertTrue($this->dealer->getScore() > $this->sam->getScore());
    $this->assertEquals($this->dealer->getScore(), 19);
  }

  public function testHighestScoreWins() {
    $deck = new Deck(__DIR__ . '/deckFiles/GameTestHighestScoreWins');
    $this->game->addDeck($deck);
    $this->game->addPlayers([ $this->sam, $this->dealer ]);
    $this->game->start();
    $this->assertEquals($this->dealer->getScore(), 20);
    $this->assertEquals($this->sam->getScore(), 19);
    $this->assertEquals($this->game->getWinner(), $this->dealer);
  }

}