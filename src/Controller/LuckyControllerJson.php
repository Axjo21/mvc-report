<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerJson extends AbstractController
{
    #[Route("/api", name: "api_home")]
    public function api(): Response 
    {
        return $this->render('api.html.twig');
    }

    #[Route("/api/quote", name: "api_quote")]
    public function jsonQuote(): Response
    {
        date_default_timezone_set('Europe/Stockholm');
        $datetime = date('Y-m-d H:i:s');

        $firstQuote = "Trefaldighetssöndagen. Är vädret klart denna dag, betyder det ett gott år.";
        $secondQuote = "Går rågen i ax på Olof bjuder Erik på kaka.";
        $thirdQuote = "Denna dag bör alla äpplen vara nedtagna och inhämtade ";

        $number = random_int(0, 100);

        if ($number <= 33) {
            $quote = $firstQuote;
        } elseif (33 <= $number && $number <= 66) {
            $quote = $secondQuote;
        } elseif ($number >= 66) {
            $quote = $thirdQuote;
        }

        $data = [
            'Dagens-Citat' => $quote,
            'Datum' => $datetime,
        ];
        //return new JsonResponse($data);
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/lucky/number")]
    public function jsonNumber(): Response
    {
        $number = random_int(0, 100);

        $data = [
            'lucky-number' => $number,
            'lucky-message' => 'Hi there!',
        ];
        //return new JsonResponse($data);
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
