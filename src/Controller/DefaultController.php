<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    private $produitRepository;

    public function __construct(ProduitRepository $produitRepository){
        $this->produitRepository = $produitRepository;

    }

    #[Route('/', name: 'default')]
    public function index(): Response
    {
        $produits = $this->produitRepository->findAll();
        $date = new \DateTime();
        return $this->render('default/index.html.twig', [
            'produits' => $produits,
            'date' => $date,
        ]);
    }

    #[Route('produit/{id}', name: 'detail')]
    public function getOne(Produit $produit){

        return $this->render('default/produit.html.twig', [
            'produit' => $produit,
        ]);
    }
}
