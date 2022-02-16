<?php

namespace App\Controller;

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


        return $this->render('default/index.html.twig', [
            'produits' => $produits,
        ]);
    }
}
