<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    
    /**
     * @Route("/",name="home")
     * @return
     */
    public function index(){
        return $this->render('pages/home.html.twig');
    }
}