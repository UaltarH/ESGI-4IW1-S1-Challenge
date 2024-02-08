<?php

namespace App\Entity;

use App\Repository\TechcareClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TechcareClientRepository::class)]
class TechcareClient extends TechcareUser
{
    #[ORM\Column(length: 255)]
    private ?string $billing_address = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phone_number = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: TechcareQuotation::class)]
    private Collection $quotations;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: TechcarePayment::class)]
    private Collection $payments;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: TechcareInvoice::class)]
    private Collection $invoices;

    #[ORM\Column]
    private ?bool $active = true;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?TechcareUser $user = null;

    public function __construct()
    {
        $this->quotations = new ArrayCollection();
        $this->payments = new ArrayCollection();
        $this->invoices = new ArrayCollection();
    }
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        $roles[] = 'ROLE_CLIENT';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

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

    public function getUser(): ?TechcareUser
    {
        return $this->user;
    }

    public function setUser(TechcareUser $user): static
    {
        $this->user = $user;

        return $this;
    }
}
