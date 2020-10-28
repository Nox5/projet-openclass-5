<?php

namespace App\Controller;

use App\Entity\BandeDessinee;
use App\Entity\WishList;
use App\Repository\BandeDessineeRepository;
use App\Repository\ChroniqueRepository;
use App\Repository\UserRepository;
use App\Repository\WishListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function getChroniques(ChroniqueRepository $chroniqueRepository, WishListRepository $wichListRepository)
    {  
        return $this->render('admin/index.html.twig', [
            'chroniques' => $chroniqueRepository->findAll(),
            'wishlist' => $wichListRepository->findOneBy([
                'user' => $this->getUser()
                ]
            ),
        ]);
    }

    /**
     * @Route("/addWishlist", name="addwishlist")
     * Permet l'ajout de BDs dans une wishlist utilisateur
     * 
     * @param WishList $wishList
     * @param BandeDessineeRepository $bandeDessineeRepository
     * @param EntityManagerInterface $entityManager
     * @return void
     */
    public function addWishlist(WishListRepository $wishListRepository, Request $request, BandeDessineeRepository $bandeDessineeRepository): Response
    {
        //Permet de se connecter à la base de donnée
        $entityManager = $this->getDoctrine()->getManager();

        //On trie et stocke l'utilisateur 'user' avec le getUser dans la variable $wishList
        $wishList = $wishListRepository->findOneBy(['user'=>$this->getUser()]);

        //Si on ne trouve pas d'utilisateur on créer une wishlist pour cet user
        if($wishList == null){
            $wishList = new WishList();
            $wishList->setUser($this->getUser());
        }
        //On récupére l'id de la bande dessinee que l'on passe dans l'url lors du clic sur le bouton ajouter(vue twig)
        //grace à la méthode request->query->get
        $idBandeDessinee = $request->query->get('id');

        //On trie et stocke l'id de la bande dessinee dans la variable $bandeDessinee
        $bandeDessinee = $bandeDessineeRepository->find($idBandeDessinee);

        //Si la bande dessinee n'existe pas
        if($bandeDessinee == null){
            throw new BadRequestException('La BD n\'a pas été trouvée !');
        }
        //On verifie si la bande dessinee n'est deja pas dans cette wishlist 
        if(!$wishList->getBandeDessinee()->contains($bandeDessinee)){
            $wishList->addBandeDessinee($bandeDessinee);
        }

        $entityManager->persist($wishList);

        $entityManager->flush();
        $this->addFlash('success', 'Ajoutée à la wishlist ! ');

        //On redirige sur la page
        return $this->redirectToRoute('bandeDessinee', [
            'id' => $idBandeDessinee
        ]);
    }

    /**
     * @Route("/deletebdwishlist", name="deletebdwishlist")
     *
     * @return void
     */
    public function deleteBdWishlist(WishListRepository $wishListRepository, Request $request, BandeDessineeRepository $bandeDessineeRepository): Response
    {
        //Permet de se connecter à la base de donnée
        $entityManager = $this->getDoctrine()->getManager();

        //Récupére la wishlist d'un utilisateur
        $wishList = $wishListRepository->findOneBy(['user'=>$this->getUser()]);
        
        //On récupére l'id de la bande dessinee que l'on passe dans l'url lors du clic sur le bouton ajouter(vue twig)
        //grace à la méthode request->query->get
        $idBandeDessinee = $request->query->get('id');
        //On trie et stocke l'id de la bande dessinee dans la variable $bandeDessinee
        $bandeDessinee = $bandeDessineeRepository->find($idBandeDessinee);

        $wishList->removeBandeDessinee($bandeDessinee);

        $entityManager->flush();

        $this->addFlash('success', 'Supprimé de la wishlist');

        return $this->redirectToRoute("admin");
    }
}
