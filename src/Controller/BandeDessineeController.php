<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\BandeDessinee;
use App\Repository\AuteurRepository;
use App\Repository\BandeDessineeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BandeDessineeController extends AbstractController
{
    /**
     * Affiche les bd du mois
     * @Route("/topbd", name="top5")
     */
    public function TopBd(BandeDessineeRepository $bandeDessineeRepository)
    {
        $bandeDessinees = $bandeDessineeRepository->findAll();

        return $this->render('bande_dessinee/top5.html.twig', [
            'bandeDessinees' => $bandeDessinees,
        ]);
    }
}
