<?php

namespace App\Entity;

use App\Repository\SensorRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SensorRepository::class)]
class Sensor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(unique: true)]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[ORM\OneToOne(mappedBy: 'sensor', targetEntity: Contract::class)]
    private ?Contract $activeContract;

    public function __toString()
    {
        return $this->name;
    }

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

    public function getActiveContract(): ?Contract
    {
        return $this->activeContract;
    }

    public function setActiveContract(Contract $activeContract): self
    {
        $this->activeContract = $activeContract;

        return $this;
    }
}
