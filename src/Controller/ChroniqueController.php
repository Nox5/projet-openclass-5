<?php

namespace App\Controller;

use App\Entity\Chronique;
use App\Repository\ChroniqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ChroniqueController extends AbstractController
{
    /**
     * @Route("/", name="chronique")
     */
    public function index(ChroniqueRepository $chroniqueRepository)
    {
        $chroniques = $chroniqueRepository->findAll();

        return $this->render('chronique/index.html.twig', [
            'chroniqueBd' => $chroniques,
        ]);
    }
}
