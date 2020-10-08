<?php

namespace App\Controller;

use App\Repository\ChroniqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function getChroniques(ChroniqueRepository $chroniqueRepository)
    {
        return $this->render('admin/index.html.twig', [
            'chroniques' => $chroniqueRepository->findAll(),
        ]);
    }
}
