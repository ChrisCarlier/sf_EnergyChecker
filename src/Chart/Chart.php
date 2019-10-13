<?php


namespace App\Chart;

use App\Repository\EnergyRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart;

class Chart
{
    const ANIMATION_STARTUP = true;
    const ANIMATION_DURATION = 1000;
    const CHART_AREA_HEIGHT = '80%';
    const CHART_AREA_WIDTH = '80%';

    private $repo;

    public function __construct(EnergyRepository $repository)
    {
        $this->repo = $repository;
    }

    public function getDataByType(string $dataType,int $year)
    {
        $currentValue = 0;

        // Récupération de tous les records pour une année
        if ($year > 0)
        {
            $DBData = $this->repo->findBy([
                'year' => $year
            ]);
        }
        else
        {
            $DBData = $this->repo->findAll();
        }

        $dataList = [];
        switch ($dataType)
        {
            case 'water' :
                $dataList[] = ['Eau','Eau'];
                foreach($DBData as $energy)
                {
                    // Initialisation de currentValue pour le calcul du premier mois
                    if($currentValue == 0)
                    {
                        $currentValue = $energy->getWater();
                    }
                    else
                    {
                        $monthName = $energy->getMonthName();
                        $newValue = $energy->getWater();
                        $dataList[] = [$monthName,$newValue - $currentValue];
                        $currentValue = $newValue;
                    }
                }
                break;
            case 'gaz' :
                $dataList[] = ['Gaz','Gaz'];
                foreach($DBData as $energy)
                {
                    // Initialisation de currentValue pour le calcul du premier mois
                    if($currentValue == 0)
                    {
                        $currentValue = $energy->getGaz();
                    }
                    else
                    {
                        $monthName = $energy->getMonthName();
                        $newValue = $energy->getGaz();
                        $dataList[] = [$monthName,$newValue - $currentValue];
                        $currentValue = $newValue;
                    }
                }
                break;
            case 'electricity' :
                $dataList[] = ['Electricité','jour','Nuit'];
                $currentValue2 = 0;
                foreach($DBData as $energy)
                {
                    // Initialisation de currentValue pour le calcul du premier mois
                    if($currentValue == 0)
                    {
                        $currentValue = $energy->getElectricityDay();
                        $currentValue2 = $energy->getElectricityNight();
                    }
                    else
                    {
                        $monthName = $energy->getMonthName();
                        $newValue = $energy->getElectricityDay();
                        $newValue2 = $energy->getElectricityNight();
                        $dataList[] = [$monthName,$newValue - $currentValue,$newValue2 - $currentValue2];
                        $currentValue = $newValue;
                        $currentValue2 = $newValue2;
                    }
                }
                dump($dataList);
                break;
        }
        return $dataList;
    }

    public function initializeBarChart(string $barTitle,string $axisTitle)
    {

        $bar = new BarChart();
        $bar->getOptions()->getAnimation()->setStartup(self::ANIMATION_STARTUP);
        $bar->getOptions()->getAnimation()->setDuration(self::ANIMATION_DURATION);
        $bar->getOptions()->getChartArea()->setHeight(self::CHART_AREA_HEIGHT);
        $bar->getOptions()->getChartArea()->setWidth(self::CHART_AREA_WIDTH);
        $bar->getOptions()->setOrientation('horizontal');
        $bar->getOptions()->getVAxis()->setMinValue(0);
        // chart title
//        $bar->getOptions()->setTitle($barTitle);
        // vAxis title
        $bar->getOptions()->getVAxis()->setTitle($axisTitle);

        return $bar;
    }

    public function waterChart(int $year)
    {
        // Récupération données Conso Eau
        $list = $this->getDataByType('water',2019);
        // Initialisation graphique
        $bar = $this->initializeBarChart('Consommation Eau','m³','');
        // Application données au graphique
        $bar->getData()->setArrayToDataTable(
            $list
        );

        return $bar;
    }

    public function gazChart(int $year)
    {
        // Récupération données Conso Gaz
        $list = $this->getDataByType('gaz',2019);
        // Initialisation graphique
        $bar = $this->initializeBarChart('Consommation Gaz','m³','');
        // Application données au graphique
        $bar->getData()->setArrayToDataTable(
            $list
        );

        return $bar;
    }

    public function electricityChart(int $year)
    {
        // Récupération données Conso Elect.
        $list = $this->getDataByType('electricity',2019);
        // Initialisation graphique
        $bar = $this->initializeBarChart('Consommation Electricité','kWh');
        // Application données au graphique
        $bar->getData()->setArrayToDataTable(
            $list
        );

        return $bar;
    }
}