<?php

namespace App\Controller;

use App\Entity\Chronique;
use App\Entity\Commentaire;
use App\Form\CommentaireFormType;
use App\Form\FormChroniqueType;
use App\Repository\ChroniqueRepository;
use App\Repository\CommentaireRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use PhpParser\Builder\Property;
use ProxyManager\ProxyGenerator\Util\Properties;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
     * @Route("/commentaires/{id}", name="commentaires", methods={"GET"})
     *
     * @param ChroniqueRepository $chroniqueRepository
     * @param [type] $id
     * @return void
     */
    public function getCommentsChronique($id, ChroniqueRepository $chroniqueCommentaire)
    {
        $commentaire = $chroniqueCommentaire->find($id);

        // On spécifie qu'on utilise l'encodeur JSON
        $encoders = [new JsonEncoder()];

        // On instancie le "normaliseur" pour convertir la collection en tableau
        $normalizers = [new ObjectNormalizer()];

        // On instancie le convertisseur
        $serializer = new Serializer($normalizers, $encoders);

        // On convertit en json
        $jsonContent = $serializer->serialize($commentaire, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        // On instancie la réponse
        $response = new Response($jsonContent);

        // On ajoute l'entête HTTP
        $response->headers->set('Content-Type', 'application/json');

        // On envoie la réponse
        return $response;
    }
}
