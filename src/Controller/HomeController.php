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

//        $form = $this->createFormBuilder()
//            ->add('year',ChoiceType::class)
//            ->getForm();

        return $this->render('pages/home.html.twig',[
            'waterBarBhart' => $chart->waterChart(2019),
            'gazBarBhart' => $chart->gazChart(2019),
            'electricityBarBhart' => $chart->electricityChart(2019),
//            'years_form' => $form
//            'distinct_year' => $this->repository->getYears()
        ]);
    }
}