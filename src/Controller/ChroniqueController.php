<?php

namespace App\Controller;

use App\Entity\Chronique;
use App\Entity\Commentaire;
use App\Form\ChroniqueFormType;
use App\Form\CommentaireFormType;
use App\Form\FormChroniqueType;
use App\Repository\ChroniqueRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use PhpParser\Builder\Property;
use ProxyManager\ProxyGenerator\Util\Properties;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChroniqueController extends AbstractController
{
    /**
     * Récupération d'une chronique(read)
     * Permet l'ajout d'un commentaire en base de donnée
     * @Route("/chronique/{id}", name="chronique")
     */
    public function index(Request $request, Chronique $chronique, EntityManagerInterface $entityManager)
    {
        $commentaire = new Commentaire();

        $form = $this->createForm(CommentaireFormType::class, $commentaire);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $commentaire->setDate(new DateTime());

            $chronique->addCommentaire($commentaire);

            $entityManager->persist($commentaire);
            $entityManager->flush();
        }

        return $this->render('chronique/chronique.html.twig', [
            'chronique' => $chronique,
            'form' => $form->createView(),
        ]);
    }


    /**
     * Ajouter une chronique(create)
     *@Route("/add-chronique", name="add_chronique")
     * @param Request $request
     * @return Response
     */
    public function addChronique(Request $request): Response
    {
        $chronique = new Chronique();

        $form = $this->createForm(ChroniqueFormType::class, $chronique);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($chronique);
            $entityManager->flush();
        }

        return $this->render("chronique/chronique-form.html.twig", [
            "form_title" => "Ajouter une chronique",
            "form_chronique" => $form->createView(),
        ]);
    }

    /**
     * Modifie une chronique(update)
     * @Route("/modify-chronique/{id}", name="modify_chronique")
     * @param Request $request
     * @param integer $id
     * @return Response
     */
    public function modifyChronique(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $chronique = $entityManager->getRepository(Chronique::class)->find($id);

        $form = $this->createForm(ChroniqueFormType::class, $chronique);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->flush();
        }

        return $this->render("chronique/chronique-form.html.twig", [
            "form_title" => "Modifier la chronique",
            "form_chronique" => $form->createView(),
        ]);
    }

    /**
     * Supprime la chronique(delete)
     * @Route("/delete-chronique/{id}", name="delete_chronique")
     * @param integer $id
     * @return Response
     */
    public function deleteChronique(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $chronique = $entityManager->getRepository(Chronique::class)->find($id);
        $entityManager->remove($chronique);
        $entityManager->flush();

        return $this->redirectToRoute("main");
    }
}
