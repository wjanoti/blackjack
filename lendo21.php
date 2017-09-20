<?php

require_once __DIR__ . '/vendor/autoload.php';

if ($argc > 2) {
  die("Usage: php lendo21.php <deck_file> \n");
} elseif ($argc === 2) {
  $deckFileName = $argv[1];
  $deck = new Deck($deckFileName);
} else {
  $deck = new Deck();
}

$dealer = new Player('Dealer');
$sam = new Player('Sam');
$game = new Game();
$game->addDeck($deck);
$game->addPlayers([$sam, $dealer]);
$game->start();
echo $game->getResults();


