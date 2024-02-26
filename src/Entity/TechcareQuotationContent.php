<?php

namespace App\Entity;

use App\Repository\TechcareQuotationContentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TechcareQuotationContentRepository::class)]
class TechcareQuotationContent
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $amount = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?TechcareProduct $product = null;

    #[ORM\ManyToOne(inversedBy: 'contents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TechcareQuotation $quotation = null;

    #[ORM\ManyToOne(inversedBy: 'contents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TechcareService $service = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getQuotation(): ?TechcareQuotation
    {
        return $this->quotation;
    }

    public function setQuotation(?TechcareQuotation $quotation): static
    {
        $this->quotation = $quotation;

        return $this;
    }

    public function getService(): ?TechcareService
    {
        return $this->service;
    }

    public function setService(?TechcareService $service): static
    {
        $this->service = $service;

        return $this;
    }

    public function getProduct(): ?TechcareProduct
    {
        return $this->product;
    }

    public function setProduct(?TechcareProduct $product): static
    {
        $this->product = $product;

        return $this;
    }
}
