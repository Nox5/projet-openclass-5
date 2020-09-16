<?php

namespace App\Controller;

use App\Repository\ChroniqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(ChroniqueRepository $chroniqueRepository)
    {
        $accueilChronique = $chroniqueRepository->findAll();

        return $this->render('accueil/accueil.html.twig', [
            'accueil' => $accueilChronique,
        ]);
    }
}
