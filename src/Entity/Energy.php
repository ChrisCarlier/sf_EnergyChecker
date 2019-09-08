<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EnergyRepository")
 */
class Energy
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @ORM\Column(type="integer")
     */
    private $month;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $electricityDay;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $electricityNight;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $gaz;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $water;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getMonth(): ?int
    {
        return $this->month;
    }

    public function setMonth(int $month): self
    {
        $this->month = $month;

        return $this;
    }

    public function getElectricityDay(): ?float
    {
        return $this->electricityDay;
    }

    public function setElectricityDay(?float $electricityDay): self
    {
        $this->electricityDay = $electricityDay;

        return $this;
    }

    public function getElectricityNight(): ?float
    {
        return $this->electricityNight;
    }

    public function setElectricityNight(?float $electricityNight): self
    {
        $this->electricityNight = $electricityNight;

        return $this;
    }

    public function getGaz(): ?float
    {
        return $this->gaz;
    }

    public function setGaz(?float $gaz): self
    {
        $this->gaz = $gaz;

        return $this;
    }

    public function getWater(): ?float
    {
        return $this->water;
    }

    public function setWater(?float $water): self
    {
        $this->water = $water;

        return $this;
    }
}
