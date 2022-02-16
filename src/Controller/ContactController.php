<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class ContactController extends AbstractController{

    #[Route('/contact',name: 'contact_page')]
    public function displayContactPage(){
        dd('Coucou');

    }


}




?>