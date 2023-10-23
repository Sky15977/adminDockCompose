<?php

namespace App\Entity;

use App\Repository\ContractRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContractRepository::class)]
class Contract
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;
    //#[ORM\Column(type: '\App\Entity\Sensor')]
    //private ?Sensor $sensor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /*public function getSensor(): ?Sensor
    {
        return $this->sensor;
    }

    public function __toString(): string
    {
        return $this->name.' '.$this->sensor->getName();
    }*/
}
