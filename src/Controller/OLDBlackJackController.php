<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\BetterCard;
use App\Card\CardHand;
use App\Card\BankHand;
use App\Card\DeckOfCards;
use App\Card\PlayerQueue;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Exception;
use RuntimeException;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BlackJackController
 * 
 * This controller handles the routes for the Blackjack game, including the home page,
 * about page, and starting a new game.
 */
class OLDBlackJackController extends AbstractController
{
    /**
     * Home page of the Project.
     * 
     * @return Response Renders the home view.
    */
    #[Route("/proj", name: "alt_proj_home", methods: ['GET'])]
    public function home(): Response
    {
        return $this->render('blackjack/home.html.twig');
    }

    /**
     * About page of the Project.
     * 
     * @return Response Renders the about view.
    */
    #[Route("/proj/about", name: "alt_proj_about", methods: ['GET'])]
    public function about(): Response
    {
        return $this->render('blackjack/about.html.twig');
    }

    /**
     * Registers players.
    */
    #[Route("/proj/init", name: "alt_proj_init", methods: ['GET'])]
    public function init(): Response {
        return $this->render('blackjack/init.html.twig');
    }

    /**
     * Begins the game.
    */
    #[Route("/proj/start", name: "alt_proj_start", methods: ['POST'])]
    public function start(
        Request $request
    ): Response {
        // get players
        $firstName = (string) $request->request->get('player1');
        $secondName = (string) $request->request->get('player2');
        $thirdName = (string) $request->request->get('player3');

        $deckOfCards = new DeckOfCards;
        $playerQueue = new PlayerQueue($deckOfCards);

        // add players to queue
        $firstName && $playerQueue->addPlayer($firstName);
        $secondName && $playerQueue->addPlayer($secondName);
        $thirdName && $playerQueue->addPlayer($thirdName);

        $playerDetails = $playerQueue->getPlayerCardDetails();

        $data = [
            "playerQueue" => $playerQueue,
            "players" => $playerDetails
        ];

        return $this->render('blackjack/start.html.twig', $data);
    }

}
