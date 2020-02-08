<?php
namespace App\Controller;

use App\Chart\Chart;
use App\Repository\EnergyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

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
     * @Route("/",name="home")
     * @param Chart $chart
     * @param Request $request
     * @return Response
     */
    public function index(Chart $chart,Request $request)
    {
        $years = $this->repository->getYears();
        $selectedYear = $request->query->get('year',$years[0]);

        return $this->render('pages/home.html.twig',[
            'waterBarBhart' => $chart->waterChart($selectedYear),
            'gazBarBhart' => $chart->gazChart($selectedYear),
            'electricityBarBhart' => $chart->electricityChart($selectedYear),
            'distinct_year' => $years,
            'selected_year' => $selectedYear
        ]);
    }
}