<?php

namespace App\Controller;

use App\Entity\BandeDessinee;
use App\Entity\WishList;
use App\Repository\BandeDessineeRepository;
use App\Repository\ChroniqueRepository;
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
            'wishlists' => $wichListRepository->findBy(
                ['user' => $this->getUser()]
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
        $entityManager = $this->getDoctrine()->getManager();

        $wishList = $wishListRepository->findOneBy(['user'=>$this->getUser()]);

        if($wishList == null){
            $wishList = new WishList();
            $wishList->setUser($this->getUser());
        }
        
        $idBandeDessinee = $request->query->get('id');

        $bandeDessinee = $bandeDessineeRepository->find($idBandeDessinee);

        if($bandeDessinee == null){
            throw new BadRequestException('La BD n\'a pas été trouvée !');
        }
        
        if(!$wishList->getBandeDessinee()->contains($bandeDessinee)){
            $wishList->addBandeDessinee($bandeDessinee);
        }

        $entityManager->persist($wishList);

        $entityManager->flush();

        return $this->redirectToRoute('bandeDessinee', [
            'id' => $idBandeDessinee
        ]);
    }
}
