<?php

class Game {

  const BLACKJACK = 21;
  const DEALER_WIN = 22;
  const PLAYER_DRAW_LIMIT = 17;
  const INITIAL_CARDS = 2;
  private $hasWinner;
  private $deck;
  private $players;
  private $winner;
  private $gameStatus;

  public function __construct() {
    $this->setStatus(GameStatus::DEAL);
  }

  public function addDeck(Deck $deck) {
    $this->deck = $deck;
  }

  public function addPlayers(array $players) {
    $this->players = $players;
  }

  public function getWinner() : Player {
    return $this->winner;
  }

  public function getStatus() : string {
    return $this->gameStatus;
  }

  public function start() {
    while ($this->getStatus() !== GameStatus::GAME_ENDED) {
      $this->play();
    } 
  }

  public function getResults() : string {
    $result = $this->getWinner()->getName() . PHP_EOL;
    foreach ($this->players as $player) {
      $result .= $player . PHP_EOL;
    }
    return $result;
  }

  // game play logic.
  private function play() : void {
    [$player, $dealer] = $this->players;
    switch ($this->getStatus()) {
      case GameStatus::DEAL: 
        $this->deal();
        break;
      case GameStatus::PLAYER_TURN:
        while ($player->getScore() < self::PLAYER_DRAW_LIMIT) {
          $player->addCardToHand($this->deck->draw());
        }
        break;
      case GameStatus::DEALER_TURN: 
        while ($dealer->getScore() <= $player->getScore() && $dealer->getScore() < self::BLACKJACK) {
          $dealer->addCardToHand($this->deck->draw());
        }
        break;  
    }
    $this->updateGame();
  }

  // deal the two initial cards to each player alternately.
  private function deal() : void {
    for ($i = 0; $i < self::INITIAL_CARDS; $i++) {
      array_walk($this->players, function ($player) {
        $player->addCardToHand($this->deck->draw());
      });
    }
  }

  private function setStatus(string $status) : void {
    $this->gameStatus = $status;
  }

  // check if the game is over and updates game status.
  private function updateGame() : void {
    [$player, $dealer] = $this->players;
    $playerScore = $player->getScore();
    $dealerScore = $dealer->getScore();

    switch ($this->getStatus()) {
      case GameStatus::DEAL: 
        $this->setStatus(GameStatus::PLAYER_TURN);
        // both got 21 after dealing the first two cards, player wins.
        if ($playerScore === self::BLACKJACK && $dealerScore === self::BLACKJACK){
          $this->winner = $player;
          $this->setStatus(GameStatus::GAME_ENDED);
        } 
        // both got 22 after dealing the first two cards, dealer wins.
        if ($playerScore === self::DEALER_WIN && $dealerScore === self::DEALER_WIN){
          $this->winner = $dealer;
          $this->setStatus(GameStatus::GAME_ENDED);
        } 
        break;
      case GameStatus::PLAYER_TURN:
        $this->setStatus(GameStatus::DEALER_TURN);
        // player exceeded 21
        if ($playerScore > self::BLACKJACK) {
          $this->winner = $dealer;
          $this->setStatus(GameStatus::GAME_ENDED);
        }
        break;
      case GameStatus::DEALER_TURN:
        $this->setStatus(GameStatus::GAME_ENDED);
        // dealer exceeded 21
        if ($dealerScore > self::BLACKJACK) {
          $this->winner = $player;
        } elseif ($playerScore > $dealerScore) {
          $this->winner = $player;
        } else {
          $this->winner = $dealer;
        }
        break;
      }
  }
    
}