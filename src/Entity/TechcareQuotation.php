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
use App\Enum\QuotationStatus;


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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $amount = '0.00';

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'quotation', targetEntity: TechcareQuotationContent::class, orphanRemoval: true)]
    private Collection $contents;

    #[ORM\ManyToOne(inversedBy: 'quotations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TechcareClient $client = null;

    #[ORM\OneToMany(mappedBy: 'quotation', targetEntity: TechcareInvoice::class, orphanRemoval: true)]
    private Collection $invoices;

    #[ORM\OneToOne(mappedBy: 'quotation', cascade: ['persist', 'remove'])]
    private ?TechcarePayment $payment = null;

    #[ORM\Column(length: 255)]
    private ?string $createdBy = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $CreatedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $UpdatedBy = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $UpdatedAt = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $discount = '0.00';

    #[ORM\Column(type: UuidType::NAME, unique: true, nullable: true)]
    private ?Uuid $token;

    public function __construct()
    {
        $this->contents = new ArrayCollection();
        $this->invoices = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

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

    public function getPayment(): ?TechcarePayment
    {
        return $this->payment;
    }

    public function setPayment(TechcarePayment $payment): static
    {
        // set the owning side of the relation if necessary
        if ($payment->getQuotation() !== $this) {
            $payment->setQuotation($this);
        }

        $this->payment = $payment;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeImmutable $CreatedAt): static
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getUpdatedBy(): ?string
    {
        return $this->UpdatedBy;
    }

    public function setUpdatedBy(?string $UpdatedBy): static
    {
        $this->UpdatedBy = $UpdatedBy;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $UpdatedAt): static
    {
        $this->UpdatedAt = $UpdatedAt;

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

    public function getToken(): ?Uuid
    {
        return $this->token;
    }

    public function setToken(?Uuid $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function generateToken()
    {
        $this->token = Uuid::v4();
    }


    //custome getters:
    public function getStatusName(): string
    {
        return match ($this->status) {
            QuotationStatus::pending->value => 'en attente de validation',
            QuotationStatus::accepted->value => 'validé',
            QuotationStatus::refused->value => 'refusé',
            QuotationStatus::paid->value => 'payé',
            default => 'Unknown'
        };
    }
}
