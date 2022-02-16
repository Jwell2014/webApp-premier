<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class PanierController extends AbstractController{

    #[Route('/panier', name: 'panier_')]
    public function listPanier(){
        dd('coucou le panier');
    }

}



?>