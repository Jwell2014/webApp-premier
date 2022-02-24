<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/produit')]
class ProduitController extends AbstractController
{
    #[Route('/', name: 'produit_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface  $slugger): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


                $imageProduit = $form->get('image')->getData();

                    $originalFilename = pathinfo($imageProduit->getClientOriginalName(), PATHINFO_FILENAME);

                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$imageProduit->guessExtension();

                    // Move the file to the directory where brochures are stored

                        $imageProduit->move(
                            $this->getParameter('product_image'),
                            $newFilename
                        );

            $produit->setImage($newFilename);

            foreach ($form->get('images') as $img){


                $imgFiles = $img->get('NomImage')->getData();

                $originalFilename=  pathinfo($imgFiles->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'-'.$imgFiles->guessExtension();

                $imgFiles->move(
                    $this->getParameter('product_image'),
                    $newFilename
                );

                $img = $img->getData();

                $img->setNomImage($newFilename);

                $produit->addImage($img);

                $img->setProduit($produit);
            }

            //J'enregistre mes produits
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'produit_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{id}/edit', name: 'produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, EntityManagerInterface $entityManager, SluggerInterface  $slugger): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //on récupère notre photo dans la requete image correspondant au nom du champ dans notre formulaire
            $imageProduit = $form->get('image')->getData();

            if ($imageProduit){
                //Génération d'un nouveau nom sécurisé et unique
                $originalFilename = pathinfo($imageProduit->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageProduit->guessExtension();


                // j'upload le fichier ans le dossier contenu dans services.yamlqui a la clé product.image
                // Je l'upload avec son  ouveau nom
                $imageProduit->move(
                    $this->getParameter('product_image'),
                    $newFilename
                );

                //Dans ma BDD j'ajoute e nom unique du fichier pour le trouver
                $produit->setImage($newFilename);

            }



           /* foreach ($form->get('images') as $img){


                $imgFiles = $img->get('NomImage')->getData();

                $originalFilename=  pathinfo($imgFiles->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'-'.$imgFiles->guessExtension();

                $imgFiles->move(
                    $this->getParameter('product_image'),
                    $newFilename
                );

                $img = $img->getData();

                $img->setNomImage($newFilename);

                $produit->addImage($img);

                $img->setProduit($produit);
            }*/

            //J'enregistre mes produits
            $entityManager->flush();

            return $this->redirectToRoute('produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'produit_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('produit_index', [], Response::HTTP_SEE_OTHER);
    }
}
