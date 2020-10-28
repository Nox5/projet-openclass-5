<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\BandeDessinee;
use App\Form\BandeDessineeType;
use App\Form\ChroniqueFormType;
use App\Repository\AuteurRepository;
use App\Repository\BandeDessineeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;
use Symfony\Flex\Response as FlexResponse;

class BandeDessineeController extends AbstractController
{
    /**
     * Affiche les bd du mois
     * @Route("/topbd", name="top5")
     */
    public function getBandesDessinees(BandeDessineeRepository $bandeDessineeRepository)
    {
        $bandeDessinees = $bandeDessineeRepository->findAll();

        return $this->render('bande_dessinee/top5.html.twig', [
            'bandeDessinees' => $bandeDessinees,
        ]);
    }

    /**
     * Affiche une bd en particulier
     * @Route("/bandeDessinee/{id}", name="bandeDessinee")
     *
     * @param BandeDessineeRepository $bandeDessineeRepository
     * @param BandeDessinee $bandeDessinee
     * @return void
     */
    public function getBandeDessinee(BandeDessinee $bandeDessinee, BandeDessineeRepository $bandeDessineeRepository)
    {

        $bandeDessinee = $bandeDessineeRepository->find($bandeDessinee);

        return $this->render('bande_dessinee/bandeDessinee.html.twig', [
            'bandeDessinee' => $bandeDessinee,
        ]);
    }

    /**
     * Permet l'ajout d'une nouvelle bande dessinée dans le top 5
     * @Route("/add_bd", name="add_bd")
     *
     * @param Request $request
     * @return void
     */
    public function addBandeDessinee(Request $request)
    {
        $bandeDessinee = new BandeDessinee();

        $form = $this->createForm(BandeDessineeType::class, $bandeDessinee);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bandeDessinee);
            $entityManager->flush();
            return $this->redirectToRoute("top5");
        }
        
        return $this->render("bande_dessinee/bandeDessineeForm.html.twig", [
            "form_title" => "Ajouter une bande dessinée",
            "form_bd" => $form->createView(),
        ]);
    }

    /**
     * Permet la suppression d'une bande dessinee du top5
     * @Route("/deleteBd/{id}", name="deleteBd")
     *
     * @return void
     */
    public function deleteBandeDessinee(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $bandeDessinee = $entityManager->getRepository(BandeDessinee::class)->find($id);

        $entityManager->remove($bandeDessinee);
        $entityManager->flush();

        $this->addFlash('success', 'BD supprimée');

        return $this->redirectToRoute("top5");
    }

    
}
