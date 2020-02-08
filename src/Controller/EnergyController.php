<?php
namespace App\Controller;

use App\Chart\Chart;
use App\Entity\Energy;
use App\Form\EnergyType;
use App\Repository\EnergyRepository;
use Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\RedirectResponse;
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

    public function __construct(EnergyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/Energy", name="energy.index")
     * @return Response
     */
    public function index()
    {
        return $this->render('/energy/energy.html.twig',[
            'current_menu' => 'energies',
//            'tableau_energies' => $this->repository->findBy([
//                'year' => 2019
//            ])
            'tableau_energies' => $this->repository->findAll()
        ]);
    }

    /**
     * @Route("/Energy/create", name="energy.new", methods="GET|POST")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function new(Request $request)
    {
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
     * @param Energy $energy
     * @param Request $request
     * @return RedirectResponse|Response
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
     * @param Energy $energy
     * @return Response
     */
    public function delete(Energy $energy)
    {
        $this->em->remove($energy);
        $this->em->flush();
        $tabenergies = $this->repository->findBy([
            'year' => 2019
        ]);
        return $this->render('/Energy/energy.html.twig',[
            'current_menu' => 'energies',
            'tableau_energies' => $tabenergies
        ]);
    }

    /**
     * @param Chart $chart
     * @param Request $request
     * @return Response
     * @Route("/Charts", name="energy.charts")
     */
    public function chartPage(Chart $chart,Request $request)
    {
        $years = $this->repository->getYears();
        $selectedYear = $request->query->get('year',$years[0]);

        return $this->render('energy/charts.html.twig',[
            'waterBarBhart' => $chart->waterChart($selectedYear),
            'gazBarBhart' => $chart->gazChart($selectedYear),
            'electricityBarBhart' => $chart->electricityChart($selectedYear),
            'distinct_year' => $years,
            'selected_year' => $selectedYear,
            'current_menu' => 'charts',
        ]);
    }

}