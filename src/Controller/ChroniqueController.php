<?php

namespace App\Controller;

use App\Entity\Chronique;
use App\Entity\Commentaire;
use App\Form\CommentaireFormType;
use App\Repository\CommentaireRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class ChroniqueController extends AbstractController
{
    /**
     * @Route("/chronique/{id}", name="chronique")
     */
    public function addCommentChronique(Request $request, Chronique $chronique, EntityManagerInterface $entityManager)
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
     * @Route("/commentaires", name="commentaires")
     *
     * @param CommentaireRepository $chroniqueRepository
     * @param [type] $id
     * @return void
     */
    public function getCommentsChronique(CommentaireRepository $comments)
    {

        $comments = $comments->getTheCommentsChronique();

        return $this->render('chronique/chronique.html.twig', [
            'comments' => $comments,
        ]);
    }
}
