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

        return $this->render('chronique/chronique.html.twig', [
            'chroniqueBd' => $chroniques,
        ]);
    }

    /**
     * @Route("/form", name="formulaire")
     *
     * @return void
     */
    public function form()
    {
        $chronique = new Chronique();

        $form = $this->createForm(FormChroniqueType::class, $chronique);

        return $this->render('chronique/chroniqueForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
