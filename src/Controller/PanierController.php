<?php
namespace App\Controller;


use App\Entity\ProductOrder;
use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/panier', name: 'panier_')]
class PanierController extends AbstractController{

    #[Route('/', name: 'list')]
    public function index(Request $request): Response
    {
       $panier = $request->getSession()->get('panier');

       //Afficher mon panier
        return $this->render('Panier/index.html.twig',[
            'panier'=> $panier,
            ]);
    }

    #[Route('/{id}', name: 'add', requirements: ["id"=> '\d+'])]
    public function add(Produit $produit, Request $request){
        // Ici je crée un nouvel object ProductOrder
        //Il permettra d'associer un produit a une quantity
        $productOrder = new ProductOrder();
        $productOrder->setProduct($produit);
        $productOrder->setQuantity(1);

        // Je recupere ma session depuis l'objet request de symfony
        $session = $request->getSession();

        // Je crée un panier vide
        $panier = [];

        // Si j'ai un panier en session je le recupere
        if ($session->has("panier")){
            $panier = $session->get('panier');
        }

        //J'ajoute l'élément dans mon tableau
        $panier[] = $productOrder;

        //Je met a jour la session avec le nouveau panier
        $session->set("panier", $panier);

        // Je redirige l'utilisateur vers le panier
        return $this->redirectToRoute('panier_list');
    }

    #[Route('/remove/{id}', name: 'remove', methods: ["GET"], requirements: ["id"=> '\d+'])]
    public function remove($id){
        return new Response("Je supprime");
    }

}



?>