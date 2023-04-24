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
    #[Route("/card", name: "card_start", methods: ['GET'])]
    public function home(
        SessionInterface $session
    ): Response {
        $cardDeck = new DeckOfCards();
        $session->set("card_deck", $cardDeck);

        return $this->render('card/home.html.twig');
    }


    #[Route("/card/deck", name: "card_deck", methods: ['GET'])]
    //döp om function
    public function deck(
        SessionInterface $session
    ): Response {
        //$cardDeck = $session->get("card_deck");
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
    ): Response {
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
        SessionInterface $session
    ): Response {
        //if (isset($_SESSION["card_deck"]) == true){
        $cardDeck = $session->get('card_deck');
        //} else {
        //    $cardDeck = new DeckOfCards();
        //}

        $drawnCard = $cardDeck-> drawCard();
        $cardsLeft = $cardDeck-> getNumberCards();
        //$cardDeck->remove($drawnCard);
        $session->set("card_deck", $cardDeck);

        //fixa hantering för ifall det är mindre än 1
        if ($cardsLeft < 1) {
            //don't let app  continue
            // kanske ha return till annan route (this->renter()...)
            // eller så hanterar jag det på själva länken till draw direkt i twig-modulen
        }

        $data = [
            "drawnCard" => $drawnCard,
            "cardsLeft" => $cardsLeft
        ];

        return $this->render('card/deck/draw.html.twig', $data);
    }

    #[Route("/card/deck/draw:{num<\d+>}", name: "card_draw:number", methods: ["GET"])]
    public function drawManyCards(
        int $num,
        SessionInterface $session
    ): Response {

        $cardDeck = $session->get('card_deck');
        $cardsLeft = $cardDeck-> getNumberCards();

        if ($num > $cardsLeft) {
            throw new \Exception("Can not draw that many cards!");
        }

        $drawnCards = [];
        for ($i = 1; $i <= $num; $i++) {
            // här skapas en ny die. kan göra samma för Card() klassen
            // men då måste jag implementera den klassen först
            //$card = new DiceGraphic();
            $drawnCard = $cardDeck-> drawCard();
            array_push($drawnCards, $drawnCard);
        }
        $cardsLeft = $cardDeck-> getNumberCards();

        $data = [
            "drawnCards" => $drawnCards,
            "cardsLeft" => $cardsLeft
        ];

        return $this->render('card/deck/draw:number.html.twig', $data);
    }
}
