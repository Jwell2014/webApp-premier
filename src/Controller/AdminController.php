<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{

    private $produitRepository;

    public function __construct(ProduitRepository $produitRepository){
        $this->produitRepository = $produitRepository;

    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $produits = $this->produitRepository->findAll();
        $date = new \DateTime();
        return $this->render('produit/index.html.twig', [
            'produits' => $produits,
            'date' => $date,
        ]);
    }
}
