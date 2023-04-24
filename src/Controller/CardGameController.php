<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCards;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardGameController extends AbstractController
{
    #[Route("/card", name: "card_start", methods: ['POST'])]
    public function home(
        SessionInterface $session
    ): Response
    {
        $cardDeck = new DeckOfCards();
        $session->set("card_deck", $cardDeck);

        return $this->render('card/home.html.twig');
    }


    #[Route("/card/deck", name: "card_deck", methods: ['GET'])]
    //döp om function
    public function deck(
        SessionInterface $session
    ): Response
    {
        // denna route kanske inte bör återställa
        $cardDeck = new DeckOfCards();
        $session->set("card_deck", $cardDeck);

        $data = [
            "cardDeck" => $cardDeck->getValues()
        ];

        return $this->render('card/deck/deck.html.twig', $data);
    }


    #[Route("/card/deck/shuffle", name: "card_shuffle", methods: ['GET'])]
    // döp om function
    public function shuffle(
        SessionInterface $session
    ): Response
    {
        $cardDeck = new DeckOfCards();

        $cardDeck->shuffleDeck();

        $session->set("card_deck", $cardDeck);

        $data = [
            "cardDeck" => $cardDeck->getValues()
        ];

        return $this->render('card/deck/shuffle.html.twig', $data);
    }


    #[Route("/card/deck/draw", name: "card_draw", methods: ['GET'])]
    // döp om function
    public function draw(
        Request $request,
        SessionInterface $session
    ): Response
    {
        if (isset($_SESSION["card_deck"])){
            $cardDeck = $request->request->get('card_deck');
        } else {
            $cardDeck = new DeckOfCards();
        }

        // logik för att dra ett kort, skriv nya till sessionen...
        $drawnCard = $cardDeck-> drawCard();
        $cardsLeft = $cardDeck-> getNumberCards();


        $data = [
            "drawnCard" => $drawnCard,
            "cardsLeft" => $cardsLeft
        ];

        return $this->render('card/deck/draw.html.twig', $data);
    }

}
