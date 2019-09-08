<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EnergyController extends AbstractController{


    /**
     * @Route("/Energy", name="Energy")
     * @return
     */
    public function index(){
        return $this->render('/Energy/energy.html.twig');
    }

}