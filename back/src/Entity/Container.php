<?php

namespace App\Entity;

use App\Repository\ContainerRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: ContainerRepository::class)]
class Container
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: Group::class, inversedBy: "containers")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Group $group;

    #[ORM\oneToMany(mappedBy: "containers", targetEntity: Contract::class)]
    private ?Collection $contracts;

    public function __construct()
    {
        $this->contracts = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): Container
    {
        $this->name = $name;

        return $this;
    }

    public function getGroup(): Group
    {
        return $this->group;
    }

    public function setGroup(Group $group): self
    {
        $this->group = $group;

        return $this;
    }

    public function getContracts(): Collection
    {
        return $this->contracts;
    }

    public function setContracts(Collection $contracts): self
    {
        $this->contracts = $contracts;

        return $this;
    }

    public function addContract(Contract $contract): self
    {
        if (!$this->contracts->contains($contract)) {
            $this->contracts[] = $contract;
            $contract->setContainer($this);
        }

        return $this;
    }

    public function removeContract(Contract $contract): self
    {
        if ($this->contracts->removeElement($contract)) {
            if ($contract->getContainer() === $this) {
                $contract->setContainer(null);
            }
        }

        return $this;
    }

    public function getNbContracts(): int
    {
        return count($this->contracts);
    }
}
