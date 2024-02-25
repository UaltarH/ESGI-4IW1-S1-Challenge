<?php

namespace App\Entity;

use App\Repository\TechcareProductComponentPriceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TechcareProductComponentPriceRepository::class)]
class TechcareProductComponentPrice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: TechcareProduct::class, inversedBy: 'techcareProductComponentPrices')]
    private Collection $product_id;

    #[ORM\ManyToMany(targetEntity: TechcareComponent::class)]
    private Collection $component_id;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $price = null;

    public function __construct()
    {
        $this->product_id = new ArrayCollection();
        $this->component_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, TechcareProduct>
     */
    public function getProductId(): Collection
    {
        return $this->product_id;
    }

    public function addProductId(TechcareProduct $productId): static
    {
        if (!$this->product_id->contains($productId)) {
            $this->product_id->add($productId);
        }

        return $this;
    }

    public function removeProductId(TechcareProduct $productId): static
    {
        $this->product_id->removeElement($productId);

        return $this;
    }

    /**
     * @return Collection<int, TechcareComponent>
     */
    public function getComponentId(): Collection
    {
        return $this->component_id;
    }

    public function addComponentId(TechcareComponent $componentId): static
    {
        if (!$this->component_id->contains($componentId)) {
            $this->component_id->add($componentId);
        }

        return $this;
    }

    public function removeComponentId(TechcareComponent $componentId): static
    {
        $this->component_id->removeElement($componentId);

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }
}
