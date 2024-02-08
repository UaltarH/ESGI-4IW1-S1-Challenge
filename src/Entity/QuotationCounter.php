<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class QuotationCounter
{
    #[ORM\Id]
    #[ORM\Column(type: "integer", unique: true)]
    private int $id;
    private int $smartphone;
    private int $computer;
    private int $tablet;
    private int $total;
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getComputer(): int
    {
        return $this->computer;
    }

    public function setComputer(int $computer): void
    {
        $this->computer = $computer;
    }

    public function getTablet(): int
    {
        return $this->tablet;
    }

    public function setTablet(int $tablet): void
    {
        $this->tablet = $tablet;
    }

    public function getSmartphone(): int
    {
        return $this->smartphone;
    }
    public function setSmartphone(int $smartphone): void
    {
        $this->smartphone = $smartphone;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function setTotal(int $total): void
    {
        $this->total = $total;
    }

}