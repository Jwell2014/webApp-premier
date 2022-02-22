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
        // récupère la session
       $panier = $request->getSession()->get('panier');

        // calcul le prix total
        $prix=0;

        foreach ($panier as $po){
            $prix += $po->getProduct()->getPrix() * $po->getQuantity();
        }

        // à faire sinon dès que le panier et vide et la session sup le panier ne s'affiche plus vu qu'il est vide
        if(!$panier){
            $panier = [];
        }



       //Afficher mon panier
        return $this->render('Panier/index.html.twig',[
            'panier'=> $panier,
            'prix' => $prix
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

       $exist = false;
        // Verifie si on as deja ce produit dans le panier
        foreach ($panier as $productOrde){
            if($productOrde->getProduct()->getId() == $produit->getId()){
                $exist = true;
                $productOrde->setQuantity($productOrde->getQuantity() + 1);
            }
        }
        if (!$exist){
            $panier[] = $productOrder;
        }


        //Je met a jour la session avec le nouveau panier
        $session->set("panier", $panier);

        // Je redirige l'utilisateur vers le panier
        return $this->redirect($request->headers->get('referer'));;
    }

    #[Route('/remove/{id}', name: 'remove')]
    public function remove(Produit $produit, Request $request){
        $session = $request->getSession();
        $panier = $session->get('panier');

        $delete = null;
        foreach ($panier as $key=>$productOrder){
            if($produit->getId() == $productOrder->getProduct()->getId()){
                $delete = $key;
            }
        }

        unset($panier[$delete]);

        $session->set('panier', $panier);

        return $this->redirectToRoute('panier_list');
    }

    // modifier la quantité directement sur le panier (le + & -)
    #[Route('/{operator}/{id}', name: 'addRemoveOne')]
    public function imcrementPanier(Produit $produit, Request $request, $operator)
    {

        $session = $request->getSession();
        $panier = $session->get('panier');

        foreach ($panier as$po){

            if($po->getProduct()->getId() == $produit->getId()){
                if($operator == 'plus'){
                    $po->setQuantity($po->getQuantity()+1);
                } elseif($operator == 'moins'and $po->getQuantity() > 0 ) {
                    $po->setQuantity($po->getQuantity()-1);
                }
            }
        }

        $session->set('panier', $panier);

        // je redirige l'utilisateur sur la page ou il est actuellement
        return $this->redirectToRoute('panier_list');
    }

}



?>