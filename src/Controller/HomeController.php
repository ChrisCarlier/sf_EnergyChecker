<?php
namespace App\Controller;

use App\Chart\Chart;
use App\Entity\Energy;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ComboChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    /**
     * @Route("/",name="home")
     * @param Chart $chart
     * @param Request $request
     * @return Response
     */
    public function index(Chart $chart,Request $request)
    {

        return $this->render('pages/home.html.twig',[
            'waterBarBhart' => $chart->waterChart(2019),
            'gazBarBhart' => $chart->gazChart(2019),
            'electricityBarBhart' => $chart->electricityChart(2019)
        ]);
    }
}