<?php

namespace App\Controller;

use App\Entity\Chronique;
use App\Form\FormChroniqueType;
use App\Repository\ChroniqueRepository;
use PhpParser\Builder\Property;
use ProxyManager\ProxyGenerator\Util\Properties;
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

        $chronique = new Chronique();

        $form = $this->createForm(FormChroniqueType::class, $chronique);

        return $this->render('chronique/chronique.html.twig', [
            'chroniqueBd' => $chroniques,
            'form' => $form->createView(),
        ]);
    }
}
