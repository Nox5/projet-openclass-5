<?php

namespace App\Controller;

use App\Entity\Chronique;
use App\Entity\Commentaire;
use App\Form\ChroniqueFormType;
use App\Form\CommentaireFormType;
use App\Repository\CommentaireRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
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
    public function addCommentChronique(PaginatorInterface $paginator, Request $request, Chronique $chronique, EntityManagerInterface $entityManager, CommentaireRepository $commentaireRepository)
    {
        $commentaire = new Commentaire();

        $form = $this->createForm(CommentaireFormType::class, $commentaire);
        
        $form->handleRequest($request);

        $paginator = $paginator->paginate(
            $commentaireRepository->getQueryForPagination($chronique),
            $request->query->getInt('page', 1),
            5
        );

        if($form->isSubmitted() && $form->isValid()){

            $commentaire->setDate(new DateTime());

            $chronique->addCommentaire($commentaire);

            $entityManager->persist($commentaire);
            $entityManager->flush();
            return $this->redirectToRoute('chronique', ['id' => $chronique->getId()]);
        }

        return $this->render('chronique/chronique.html.twig', [
            'chronique' => $chronique,
            'form' => $form->createView(),
            'commentaires' => $paginator
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
