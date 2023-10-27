<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ORM\Table(name: '`group`')]
class Group
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: Organization::class, inversedBy:"groups")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Organization $organization;

    #[ORM\OneToMany(mappedBy: "group", targetEntity: Container::class)]
    private ?Collection $containers;

    public function __construct()
    {
        $this->containers = new ArrayCollection();
    }

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

    public function getOrganization(): Organization
    {
        return $this->organization;
    }

    public function setOrganization(Organization $organization): self
    {
        $this->organization = $organization;

        return $this;
    }

    public function getContainers(): Collection
    {
        return $this->containers;
    }

    public function setContainers(Collection $containers): self
    {
        $this->containers = $containers;

        return $this;
    }

    public function addContainer(Container $container): self
    {
        if (!$this->containers->contains($container)) {
            $this->containers[] = $container;
            $container->setGroup($this);
        }

        return $this;
    }

    public function removeContainer(Container $container): self
    {
        if ($this->containers->removeElement($container)) {
            if ($container->getGroup() === $this) {
                $container->setGroup(null);
            }
        }

        return $this;
    }

    public function getNbContainers(): int
    {
        return count($this->containers);
    }
}
