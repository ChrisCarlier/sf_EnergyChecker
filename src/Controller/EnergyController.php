<?php
namespace App\Controller;

use App\Entity\Energy;
use App\Form\EnergyType;
use App\Repository\EnergyRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EnergyController extends AbstractController{

    /**
     * @var EnergyRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(EnergyRepository $repository, ObjectManager $em){
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/Energy", name="energy.index")
     * @return
     */
    public function index(){

        $tabenergies = $this->repository->findAll();

        return $this->render('/Energy/energy.html.twig',[
            'current_menu' => 'energies',
            'tableau_energies' => $tabenergies
        ]);
    }

    /**
     * @Route("/Energy/create", name="energy.new", methods="GET|POST")
     * @return
     */
    public function new(Request $request){
        $energy = new Energy();
        $form = $this->createForm(EnergyType::class, $energy);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($energy);
            $this->em->flush();
            return $this->redirectToRoute('energy.index');
        }

        return $this->render('energy/new.html.twig', [
            'energy' => $energy,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/Energy/{id}", name="energy.edit", methods="GET|POST")
     * @return
     */
    public function edit(Energy $energy, Request $request)
    {
        $form = $this->createForm(EnergyType::class, $energy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            return $this->redirectToRoute('energy.index');
        }

        return $this->render('energy/edit.html.twig', [
            'energy' => $energy,
            'form' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/Energy/{id}", name="energy.delete", methods="DELETE")
     * @return
     */
    public function delete(Energy $energy)
    {
        $this->em->remove($energy);
        $this->em->flush();
        return new Response('suppression');
    }

}