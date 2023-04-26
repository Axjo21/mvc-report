<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCards;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ApiControllerJson extends AbstractController
{
    #[Route("/api", name: "api_home")]
    public function api(): Response 
    {
        return $this->render('api.html.twig');
    }

    #[Route("/api/deck", name: "api_deck", methods:["GET"])]
    public function deck(
        SessionInterface $session
    ): Response {
        $cardDeck = new DeckOfCards();
        $session->set("card_deck", $cardDeck);
        $data = [
            "cardDeck" => $cardDeck->getValues()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/shuffle", name: "api_shuffle", methods:["GET"])]
    public function shuffleDeck(
        SessionInterface $session
    ): Response {
        $cardDeck = new DeckOfCards();

        $cardDeck->shuffleDeck();

        $session->set("card_deck", $cardDeck);

        $data = [
            "cardDeck" => $cardDeck->getValues()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

        #[Route("/api/deck/draw", name: "api_draw", methods:["GET"])]
        public function drawDeck(
            SessionInterface $session
        ): Response {
            $cardDeck = $session->get('card_deck');
            $drawnCard = $cardDeck-> drawCard();
            $session->set("card_deck", $cardDeck);

            $response = new JsonResponse($drawnCard);
            $response->setEncodingOptions(
                $response->getEncodingOptions() | JSON_PRETTY_PRINT
            );
            return $response;
        }


    #[Route("/api/deck/draw:{num<\d+>}", name: "api_draw:number", requirements: ['num' => '\d+'])]
    public function testDiceHand(
        SessionInterface $session,
        int $num = 1
        ): Response {
            $cardDeck = $session->get('card_deck');
            $cardsLeft = $cardDeck-> getNumberCards();
            if ($num > $cardsLeft) {
                throw new \Exception("Can not draw that many cards!");
            }
            $hand = new CardHand();
            for ($i = 1; $i <= $num; $i++) {
                $drawnCard = $cardDeck-> drawCard();
                $hand->add(new Card($drawnCard));
            }

            $response = new JsonResponse($hand->getValues());
            $response->setEncodingOptions(
                $response->getEncodingOptions() | JSON_PRETTY_PRINT
            );
            return $response;
        }
}
