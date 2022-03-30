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
        $produits = $this->produitRepository->findBy(['produitPhare' => true]);
        $produitphare= [];
        $date = new \DateTime();
        if($produits){
            shuffle($produits);
            $i=0;
            $j=0;
            foreach ($produits as $produit){
                if ($i%4 == 0) $j++;
                $produitphare[$j][] = $produit;
                $i++;
            }
        }
        return $this->render('default/index.html.twig', [
            'produitphare' => $produitphare,
            'date' => $date,
        ]);
    }

    #[Route('detail/{id}', name: 'detail')]
    public function getOne(Produit $produit){

        return $this->render('default/produit.html.twig', [
            'produit' => $produit,
        ]);
    }
}
