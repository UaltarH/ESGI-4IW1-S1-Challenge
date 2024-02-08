<?php

namespace App\Entity;

use App\Repository\TechcarePaymentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TechcarePaymentRepository::class)]
class TechcarePayment
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $amount = null;

    #[ORM\Column(length: 255)]
    private ?string $method = null;

    #[ORM\Column(length: 255)]
    private ?string $payment_number = null;

    #[ORM\ManyToOne(inversedBy: 'payments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TechcareClient $client = null;

    #[ORM\OneToOne(inversedBy: 'payment', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?TechcareQuotation $quotation = null;

    #[ORM\OneToOne(mappedBy: 'payment', cascade: ['persist', 'remove'])]
    private ?TechcareInvoice $invoice = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

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

    public function getClient(): ?TechcareClient
    {
        return $this->client;
    }

    public function setClient(?TechcareClient $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function setMethod(string $method): static
    {
        $this->method = $method;

        return $this;
    }

    public function getPaymentNumber(): ?string
    {
        return $this->payment_number;
    }

    public function setPaymentNumber(string $payment_number): static
    {
        $this->payment_number = $payment_number;

        return $this;
    }

    public function getQuotation(): ?TechcareQuotation
    {
        return $this->quotation;
    }

    public function setQuotation(TechcareQuotation $quotation): static
    {
        $this->quotation = $quotation;

        return $this;
    }

    public function getInvoice(): ?TechcareInvoice
    {
        return $this->invoice;
    }

    public function setInvoice(TechcareInvoice $invoice): static
    {
        // set the owning side of the relation if necessary
        if ($invoice->getPayment() !== $this) {
            $invoice->setPayment($this);
        }

        $this->invoice = $invoice;

        return $this;
    }
}
