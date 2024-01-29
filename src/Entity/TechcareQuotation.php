<?php

namespace App\Entity;

use App\Repository\TechcareQuotationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TechcareQuotationRepository::class)]
class TechcareQuotation
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Unique]
    private ?string $quotation_number = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $amount = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $discount = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $final_amount = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column]
    private ?bool $water_damage = null;

    #[ORM\OneToMany(mappedBy: 'quotation', targetEntity: TechcareQuotationContent::class, orphanRemoval: true)]
    private Collection $contents;

    #[ORM\ManyToOne(inversedBy: 'quotations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TechcareClient $client = null;

    #[ORM\OneToMany(mappedBy: 'quotation', targetEntity: TechcareInvoice::class, orphanRemoval: true)]
    private Collection $invoices;

    public function __construct()
    {
        $this->contents = new ArrayCollection();
        $this->invoices = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getQuotationNumber(): ?string
    {
        return $this->quotation_number;
    }

    public function setQuotationNumber(string $quotation_number): static
    {
        $this->quotation_number = $quotation_number;

        return $this;
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

    public function getDiscount(): ?string
    {
        return $this->discount;
    }

    public function setDiscount(?string $discount): static
    {
        $this->discount = $discount;

        return $this;
    }

    public function getFinalAmount(): ?string
    {
        return $this->final_amount;
    }

    public function setFinalAmount(string $final_amount): static
    {
        $this->final_amount = $final_amount;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function isWaterDamage(): ?bool
    {
        return $this->water_damage;
    }

    public function setWaterDamage(bool $water_damage): static
    {
        $this->water_damage = $water_damage;

        return $this;
    }

    /**
     * @return Collection<int, TechcareQuotationContent>
     */
    public function getContents(): Collection
    {
        return $this->contents;
    }

    public function addContent(TechcareQuotationContent $content): static
    {
        if (!$this->contents->contains($content)) {
            $this->contents->add($content);
            $content->setQuotation($this);
        }

        return $this;
    }

    public function removeContent(TechcareQuotationContent $content): static
    {
        if ($this->contents->removeElement($content)) {
            // set the owning side to null (unless already changed)
            if ($content->getQuotation() === $this) {
                $content->setQuotation(null);
            }
        }

        return $this;
    }

    public function getClient(): ?TechcareClient
    {
        return $this->client;
    }

    public function setClient(?TechcareClient $client): static
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, TechcareInvoice>
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function addInvoice(TechcareInvoice $invoice): static
    {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices->add($invoice);
            $invoice->setQuotation($this);
        }

        return $this;
    }

    public function removeInvoice(TechcareInvoice $invoice): static
    {
        if ($this->invoices->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getQuotation() === $this) {
                $invoice->setQuotation(null);
            }
        }

        return $this;
    }
}
