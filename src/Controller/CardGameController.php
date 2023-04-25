<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\BetterCard;
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
        $cardDeck = $session->get('card_deck');

        $drawnCard = $cardDeck-> drawCard();
        $cardsLeft = $cardDeck-> getNumberCards();
        $session->set("card_deck", $cardDeck);

        $data = [
            "drawnCard" => $drawnCard,
            "cardsLeft" => $cardsLeft
        ];

        return $this->render('card/deck/draw.html.twig', $data);
    }



    #[Route("/card/deck/draw/start", name: "card_draw:number_start")]
    public function drawStartCallback(): Response
    {
        return $this->render('card/deck/init.number.html.twig');
    }


    #[Route("/card/deck/draw/init", name: "card_draw:number_init", methods: ['POST'])]
    public function drawInitCallback(
        Request $request,
        SessionInterface $session
    ): Response
    {
        $num = $request->request->get('num_cards');
        $session->set("num_cards", $num);

        return $this->redirectToRoute('card_draw:number');
    }
    

    #[Route("/card/deck/draw/number", name: "card_draw:number", methods: ["GET"])]
    public function drawNumberCards(
        SessionInterface $session
    ): Response {
        $cardDeck = $session->get('card_deck');
        $numCards = $session->get('num_cards');
        $cardsLeft = $cardDeck-> getNumberCards();

        if ($numCards > $cardsLeft) {
            throw new \Exception("Can not draw that many cards!");
        }

        $drawnCards = [];
        $hand = new CardHand();
        for ($i = 1; $i <= $numCards; $i++) {
            $drawnCard = $cardDeck-> drawCard();
            $hand->add(new Card($drawnCard));
            //array_push($drawnCards, $drawnCard);
        }
        $cardsLeft = $cardDeck-> getNumberCards();

        $data = [
            "drawnHand" => $hand->getValues(),
            "drawnCards" => $drawnCards,
            "cardsLeft" => $cardsLeft
        ];

        return $this->render('card/deck/draw:number.html.twig', $data);
    }
}
