<?php

namespace App\Controller;

use App\Card\PlayerQueue;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
    public function init(): Response
    {
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

        $playerCount = 0;
        $playerData = [];
        $playerQueue = new PlayerQueue();
        $playerOne = null;
        $playerTwo = null;
        $playerThree = null;

        // check if player 1 is set
        $firstName = (string) $request->request->get('player1');
        if ($firstName) {
            $playerOne = $playerQueue->addPlayer($firstName);
            $playerCount++;
            $data = ["name" => $firstName, "playerNumber" => $playerCount];
            array_push($playerData, $data);
        }

        // check if player 2 is set
        $secondName = (string) $request->request->get('player2');
        if ($secondName) {
            $playerTwo = $playerQueue->addPlayer($secondName);
            $playerCount++;
            $data = ["name" => $secondName, "playerNumber" => $playerCount];
            array_push($playerData, $data);
        }
        
        // check if player 3 is set
        $thirdName = (string) $request->request->get('player3');
        if ($thirdName) {
            $playerThree = $playerQueue->addPlayer($thirdName);
            $playerCount++;
            $data = ["name" => $thirdName, "playerNumber" => $playerCount];
            array_push($playerData, $data);
        }

        // create bank hand
        $bankPlayer = $playerQueue->addBank("Bank");
        $session->set("playerQueue", $playerQueue);


        // kolla ifall någon redan har vunnit
        if ($playerOne || $playerTwo || $playerThree || $bankPlayer) {
            $winners = $playerQueue->calculateWinner();
            $session->set("winnerName", $winners[0]->data->name);
            $session->set("winnerPoints", $winners[0]->data->getPoints());
        }


        $data = [
            "playerNames" => $playerData
        ];

        return $this->render('blackjack/bets.html.twig', $data);
    }

    /**
     * This route gets executed whenever a player has requested to draw a card.
     * The linked list keeps track of which players turn it is.
    */
    #[Route("/proj/draw", name: "proj_draw", methods: ['GET'])]
    public function draw(
        SessionInterface $session
    ): Response {

        $playerQueue = $session->get('playerQueue');
        if ($playerQueue instanceof PlayerQueue) {
            $playerQueue->drawCardForCurrentPlayer();

            $banksTurn = $playerQueue->banksTurn();
            $players = $playerQueue->getPlayerDataAsArray();

            $data = [
                "players" => $players,
                "banksTurn" => $banksTurn,
                "winnerName" => null
            ];

            return $this->render('blackjack/start.html.twig', $data);
        }
        return $this->render('blackjack/error.html.twig');
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
        if ($playerQueue instanceof PlayerQueue) {
            $playerQueue->advanceQueue();
            
            // här exekveras även bankens tur, ifall det är det. bool representation på ifall det är bankens tur returneras. 
            $banksTurn = $playerQueue->banksTurn();
            $players = $playerQueue->getPlayerDataAsArray();

            // Winner: No winner 0 You won: 0
            // när spelare van, spelare hade 20, annan spelare hade mer än 21, bank hade mer än 21
            if ($banksTurn) {
                $winners = $playerQueue->calculateWinner();
                if (count($winners) > 0) { // ifall en eller fler vinnare
                    $data = [
                        "players" => $players,
                        "banksTurn" => $banksTurn,
                        "winnerName" => $winners[0]->data->name,
                        "winnerPoints" => $winners[0]->data->getPoints(),
                        "winnerBetPool" => $winners[0]->getBetPool(),
                        "totalBetPool" => $playerQueue->getPlacedBets()
                    ];
                } else { // ifall ingen vinnare
                    $data = [
                        "players" => $players,
                        "banksTurn" => $banksTurn,
                        "winnerName" => "No winner",
                        "winnerPoints" => 0,
                        "winnerBetPool" => 0
                    ];
                }
        
                return $this->render('blackjack/start.html.twig', $data);
            }
            $data = [
                "players" => $players,
                "banksTurn" => $banksTurn,
                "winnerName" => null
            ];

            return $this->render('blackjack/start.html.twig', $data);
        }
        return $this->render('blackjack/error.html.twig');
    }


    /**
     * Route for handling of bet placement. 
    */
    #[Route("/proj/placeBet", name: "proj_place_bet", methods: ['POST'])]
    public function placeBet(
        Request $request,
        SessionInterface $session
    ): Response {
        $playerQueue = $session->get('playerQueue');
        if ($playerQueue instanceof PlayerQueue) {
            $placedBetOne = (int) $request->request->get('place-bet-1');
            $placedBetTwo = (int) $request->request->get('place-bet-2');
            $placedBetThree = (int) $request->request->get('place-bet-3');
    
            $placedBetOne && $playerQueue->placeBet($placedBetOne, 1);
            $placedBetTwo && $playerQueue->placeBet($placedBetTwo, 2);
            $placedBetThree && $playerQueue->placeBet($placedBetThree, 3);
    
            $banksTurn = $playerQueue->banksTurn();
            $players = $playerQueue->getPlayerDataAsArray();
    
            $data = [
                "players" => $players,
                "banksTurn" => $banksTurn,
                "winnerName" => null
            ];
    
            return $this->render('blackjack/start.html.twig', $data);
        }

        return $this->render('blackjack/error.html.twig');
    }
}
