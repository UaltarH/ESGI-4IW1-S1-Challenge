<?php

namespace App\Entity;

use App\Repository\TechcareProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TechcareProductRepository::class)]
class TechcareProduct
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255)]
    private ?string $createdBy = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $updatedBy = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 4, nullable: true)]
    private ?string $release_year = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?TechcareBrand $brand = null;

    #[ORM\ManyToOne(inversedBy: 'product')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TechcareProductCategory $productCategory = null;

    #[ORM\ManyToMany(targetEntity: TechcareProductComponentPrice::class, mappedBy: 'product_id')]
    private Collection $techcareProductComponentPrices;

    public function __construct()
    {
        $this->techcareProductComponentPrices = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getReleaseYear(): ?string
    {
        return $this->release_year;
    }

    public function setReleaseYear(?string $release_year): static
    {
        $this->release_year = $release_year;

        return $this;
    }

    public function getBrand(): ?TechcareBrand
    {
        return $this->brand;
    }

    public function setBrand(?TechcareBrand $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getProductCategory(): ?TechcareProductCategory
    {
        return $this->productCategory;
    }

    public function setProductCategory(?TechcareProductCategory $productCategory): static
    {
        $this->productCategory = $productCategory;

        return $this;
    }

    /**
     * @return Collection<int, TechcareProductComponentPrice>
     */
    public function getTechcareProductComponentPrices(): Collection
    {
        return $this->techcareProductComponentPrices;
    }

    public function addTechcareProductComponentPrice(TechcareProductComponentPrice $techcareProductComponentPrice): static
    {
        if (!$this->techcareProductComponentPrices->contains($techcareProductComponentPrice)) {
            $this->techcareProductComponentPrices->add($techcareProductComponentPrice);
            $techcareProductComponentPrice->addProductId($this);
        }

        return $this;
    }

    public function removeTechcareProductComponentPrice(TechcareProductComponentPrice $techcareProductComponentPrice): static
    {
        if ($this->techcareProductComponentPrices->removeElement($techcareProductComponentPrice)) {
            $techcareProductComponentPrice->removeProductId($this);
        }

        return $this;
    }
}
