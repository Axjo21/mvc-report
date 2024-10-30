<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
