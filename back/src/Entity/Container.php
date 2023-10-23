<?php

namespace App\Entity;

use App\Repository\ContainerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContainerRepository::class)]
class Container
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;
    //#[ORM\Column(type: '\App\Entity\Contract')]
    //private ?Contract $contract = null;

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

    /*public function getContracts(): ?Contract
    {
        return $this->contract;
    }

    public function __toString(): string
    {
        return $this->name.' '.$this->contract->getName();
    }*/
}
