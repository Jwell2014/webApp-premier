<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Repository\ProduitRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'search')]
    public function index(Request $request, ProduitRepository $pr): Response
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        $produits = $pr->findAll();

        if($form->isSubmitted() and $form->isValid()){
            $filter = $form->getData();
            $produits = $pr->search($filter);
        }

        return $this->render('search/index.html.twig', [
            'form' => $form->createView(),
            'produits'=> $produits,
        ]);
    }
}
