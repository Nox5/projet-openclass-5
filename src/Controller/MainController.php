<?php

namespace App\Controller;

use App\Repository\ChroniqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * Affiche les chroniques sur la page d'accueil
     * @Route("/", name="main")
     */
    public function viewChroniques(ChroniqueRepository $chroniqueRepository)
    {
        $chronique = $chroniqueRepository->findAll();

        return $this->render('main/accueil.html.twig', [
            'accueilChronique' => $chronique,
        ]);
    }
}
