<?php

namespace App\Controller;

// modeller (klasserna) -> ha mycket kod
use App\Card\Card;
use App\Card\BetterCard;
use App\Card\CardHand;
use App\Card\BankHand;
use App\Card\DeckOfCards;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Exception;
use RuntimeException;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    // välkommen
    #[Route("/game", name: "game_home", methods: ['GET'])]
    public function home(): Response
    {
        return $this->render('twenty-one/home.html.twig');
    }

    // documentation
    #[Route("/game/doc", name: "game_doc", methods: ['GET'])]
    public function doc(): Response
    {
        return $this->render('twenty-one/doc.html.twig');
    }

    // initiera spelet
    #[Route("/game/start", name: "game_start", methods: ['GET'])]
    public function start(
        SessionInterface $session
    ): Response {
        $cardDeck = new DeckOfCards();
        $session->set("card_deck", $cardDeck);

        $cardHand = new CardHand();
        $session->set("card_hand", $cardHand);

        return $this->redirectToRoute('game_draw');
    }

    // route för när spelaren drar ett kort
    #[Route("/game/draw", name: "game_draw", methods: ['GET'])]
    public function draw(
        SessionInterface $session
    ): Response {
        $cardDeck = $session->get('card_deck');
        $cardHand = $session->get('card_hand');

        if (!$cardHand instanceof CardHand || !$cardDeck instanceof DeckOfCards) {
            throw new RuntimeException('Session data does not match expected content.');
        }
        $drawnCard = $cardDeck-> drawCard();
        $cardsLeft = $cardDeck-> getNumberCards();
        $cardHand->add($drawnCard);

        $session->set("card_deck", $cardDeck);

        $data = [
            "drawnCard" => [$drawnCard],
            "cardsLeft" => $cardsLeft,
            "cardHand" => $cardHand->getValues(),
            "cardPoints" => $cardHand->getPoints()
        ];

        return $this->render('twenty-one/game.html.twig', $data);
    }

    // route för banken, samtliga kort dras och renderas samtidigt
    #[Route("/game/stop", name: "game_stop", methods: ['GET'])]
    public function done(
        SessionInterface $session
    ): Response {
        $cardDeck = $session->get('card_deck');
        $cardHand = $session->get('card_hand');


        if (!$cardHand instanceof CardHand || !$cardDeck instanceof DeckOfCards) {
            throw new RuntimeException('Session data does not match expected content.');
        }

        $bankHand = new BankHand($cardDeck);

        // dra kort genom bank-klassen som i sin tur drar genom deck-klassen
        $bankHand ->drawCards();
        $session->set("bank_hand", $bankHand);

        // uppdatera (onödig)
        //$session->set("bank_hand", $bankHand);

        $data = [
            "cardHand" => $cardHand->getValues(),
            "bankHand" => $bankHand->getValues(),
            "cardPoints" => $cardHand->getPoints(),
            "bankPoints" => $bankHand->getPoints()
        ];

        return $this->render('twenty-one/final.html.twig', $data);
    }
}
