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
        //$cardDeck = $session->get("card_deck");
        $cardDeck = new DeckOfCards();
        $session->set("card_deck", $cardDeck);
        $data = [
            "cardDeck" => $cardDeck->getValues()
        ];

        //return new JsonResponse($data);
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    //denna ska tydligen vara POST?
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

        //return new JsonResponse($data);
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
