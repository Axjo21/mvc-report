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
use Symfony\Component\HttpFoundation\Exception;
use RuntimeException;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class MetricsController extends AbstractController
{
    // välkommen
    #[Route("/metrics", name: "metrics_home", methods: ['GET'])]
    public function home(): Response
    {
        return $this->render('metrics.html.twig');
    }




}
