<?php

namespace App\Entity;

use App\Repository\TechcareClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TechcareClientRepository::class)]
class TechcareClient
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    protected ?Uuid $id = null;

    #[ORM\Column(length: 50)]
    protected ?string $firstname = null;

    #[ORM\Column(length: 50)]
    protected ?string $lastname = null;

    #[ORM\Column(length: 180, unique: true)]
    protected ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $billing_address = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phone_number = null;

    #[ORM\Column(length: 255)]
    private ?string $createdBy = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $updatedBy = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'client')]
    protected ?TechcareCompany $company = null;


    #[ORM\OneToMany(mappedBy: 'client', targetEntity: TechcareQuotation::class)]
    private Collection $quotations;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: TechcarePayment::class)]
    private Collection $payments;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: TechcareInvoice::class)]
    private Collection $invoices;

    #[ORM\Column]
    private ?bool $active = true;


    public function __construct()
    {
        $this->quotations = new ArrayCollection();
        $this->payments = new ArrayCollection();
        $this->invoices = new ArrayCollection();
    }
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getBillingAddress(): ?string
    {
        return $this->billing_address;
    }

    public function setBillingAddress(string $billing_address): static
    {
        $this->billing_address = $billing_address;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(?string $phone_number): static
    {
        $this->phone_number = $phone_number;

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

    public function getUpdatedBy(): ?string
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(string $updatedBy): static
    {
        $this->updatedBy = $updatedBy;

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, TechcareQuotation>
     */
    public function getQuotations(): Collection
    {
        return $this->quotations;
    }

    public function addQuotation(TechcareQuotation $quotation): static
    {
        if (!$this->quotations->contains($quotation)) {
            $this->quotations->add($quotation);
            $quotation->setClient($this);
        }

        return $this;
    }

    public function removeQuotation(TechcareQuotation $quotation): static
    {
        if ($this->quotations->removeElement($quotation)) {
            // set the owning side to null (unless already changed)
            if ($quotation->getClient() === $this) {
                $quotation->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TechcarePayment>
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(TechcarePayment $payment): static
    {
        if (!$this->payments->contains($payment)) {
            $this->payments->add($payment);
            $payment->setClient($this);
        }

        return $this;
    }

    public function removePayment(TechcarePayment $payment): static
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getClient() === $this) {
                $payment->setClient(null);
            }
        }

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
            $invoice->setClient($this);
        }

        return $this;
    }

    public function removeInvoice(TechcareInvoice $invoice): static
    {
        if ($this->invoices->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getClient() === $this) {
                $invoice->setClient(null);
            }
        }

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getCompany(): ?TechcareCompany
    {
        return $this->company;
    }

    public function setCompany(?TechcareCompany $company): static
    {
        $this->company = $company;

        return $this;
    }
}
