<?php

namespace App\Entity;

use App\Repository\TechcareRoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TechcareRoleRepository::class)]
class TechcareRole
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255)]
    private ?string $createdBy = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $updatedBy = null;

    #[ORM\Column(length: 16)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: TechcareUser::class, mappedBy: 'role')]
    private Collection $techcareUsers;

    public function __construct()
    {
        $this->techcareUsers = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function setCreatedBy(string $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUpdatedBy(): ?string
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(string $updatedBy): static
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * @return Collection<int, TechcareUser>
     */
    public function getTechcareUsers(): Collection
    {
        return $this->techcareUsers;
    }

    public function addTechcareUser(TechcareUser $techcareUser): static
    {
        if (!$this->techcareUsers->contains($techcareUser)) {
            $this->techcareUsers->add($techcareUser);
            $techcareUser->addRole($this);
        }

        return $this;
    }

    public function removeTechcareUser(TechcareUser $techcareUser): static
    {
        if ($this->techcareUsers->removeElement($techcareUser)) {
            $techcareUser->removeRole($this);
        }

        return $this;
    }
}
