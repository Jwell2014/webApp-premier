<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    private $produitRepository;

    public function __construct(ProduitRepository $produitRepository){
        $this->produitRepository = $produitRepository;

    }
    #[Route('/page', name: 'page')]
    public function index(): Response
    {
        $produits = $this->produitRepository->findAll();
        return $this->render('page/index.html.twig', [
            'produits' => $produits,
        ]);
    }
}
