<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\BetterCard;
use App\Card\CardHand;
use App\Card\BankHand;
use App\Card\DeckOfCards;
use App\Card\PlayerQueue;
use App\Card\LinkedList;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use RuntimeException;

use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BlackJackController
 * 
 * This controller handles the routes for the Blackjack game, including the home page,
 * about page, and starting a new game.
 */
class BlackJackController extends AbstractController
{
    /**
     * Home page of the Project.
     * 
     * @return Response Renders the home view.
    */
    #[Route("/proj", name: "proj_home", methods: ['GET'])]
    public function home(): Response
    {
        return $this->render('blackjack/home.html.twig');
    }

    /**
     * About page of the Project.
     * 
     * @return Response Renders the about view.
    */
    #[Route("/proj/about", name: "proj_about", methods: ['GET'])]
    public function about(): Response
    {
        return $this->render('blackjack/about.html.twig');
    }

    /**
     * Registers players.
    */
    #[Route("/proj/init", name: "proj_init", methods: ['GET'])]
    public function init(): Response {
        return $this->render('blackjack/init.html.twig');
    }

    /**
     * Begins the game.
     * The 1-3 players are stored as nodes in a linked list
     * and each player draws 2 cards to begin with.
     * Renders page where the players and their 2 cards are displayed
     * and the players turn are prompted to either hold or draw a card. 
    */
    #[Route("/proj/start", name: "proj_start", methods: ['GET', 'POST'])]
    public function start(
        Request $request,
        SessionInterface $session
    ): Response {

        $playerQueue = new LinkedList();

        // check if player 1 is set
        $firstName = (string) $request->request->get('player1');
        $firstName && $playerQueue->addPlayer($firstName);

        // check if player 2 is set
        $secondName = (string) $request->request->get('player2');
        $secondName && $playerQueue->addPlayer($secondName);

        // check if player 3 is set
        $thirdName = (string) $request->request->get('player3');
        $thirdName && $playerQueue->addPlayer($thirdName);

        // create bank hand
        $playerQueue->addPlayer("Bank", true);

        $session->set("playerQueue", $playerQueue);

        $players = $playerQueue->getPlayerDataAsArray();
        $banksTurn = $playerQueue->banksTurn();
        $data = [
            "players" => $players,
            "banksTurn" => $banksTurn
        ];

        return $this->render('blackjack/start.html.twig', $data);
    }

    /**
     * This route gets executed whenever a player has requested to draw a card.
     * The linked list keeps track of which players turn it is.
    */
    #[Route("/proj/draw", name: "proj_draw", methods: ['GET'])]
    public function draw(
        Request $request,
        SessionInterface $session
    ): Response {

        $playerQueue = $session->get('playerQueue');

        $playerQueue->drawCardForCurrentPlayer();

        $players = $playerQueue->getPlayerDataAsArray();
        $banksTurn = $playerQueue->banksTurn(); // tror ej behövs här
        $data = [
            "players" => $players,
            "banksTurn" => $banksTurn
        ];

        return $this->render('blackjack/start.html.twig', $data);
    }

    /**
     * This route gets executed whenever a player has requested to draw a card.
     * The linked list keeps track of which players turn it is.
    */
    #[Route("/proj/hold", name: "proj_hold", methods: ['GET'])]
    public function hold(
        SessionInterface $session
    ): Response {

        $playerQueue = $session->get('playerQueue');

        $playerQueue->advanceQueue();

        $players = $playerQueue->getPlayerDataAsArray();
        $banksTurn = $playerQueue->banksTurn();
        $data = [
            "players" => $players,
            "banksTurn" => $banksTurn
        ];

        return $this->render('blackjack/start.html.twig', $data);
    }
    
    
}
