<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/panier')]
class PanierController extends AbstractController{

    #[Route('/', name: 'listPanier', methods: ["GET"])]
    public function listPanier(){
        return new Response("votre panier");
    }

    #[Route('/add', name: 'add_panier', methods: ["POST"])]
    public function add(){
        return new Response("J'ajoute des article au panier");
    }

    #[Route('/remove/{id}', name: 'remove_panier', methods: ["GET"], requirements: ["id"=> '\d+'])]
    public function remove($id){
        return new Response("Je supprime");
    }

}



?>