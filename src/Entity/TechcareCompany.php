<?php

namespace App\Entity;

use App\Repository\TechcareCompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TechcareCompanyRepository::class)]
#[Vich\Uploadable]
class TechcareCompany
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    /**
     * Règles du code
     * - Initiales du propriétaire (prénom + nom)
     * - 4 premières lettres du nom de la société si plus de 4 caractères
     * - Nom de la société si moins de 4 caractères
     */
    #[ORM\Column(length: 10)]
    private ?string $code = null;
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 14)] // siret est composé du n° siren et du NIC: 123 456 789 - 12345
    private ?string $siret = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phone_number = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column]
    private ?bool $active = true;

    #[Vich\UploadableField(mapping: 'companyLogo', fileNameProperty: 'imageName', size: 'imageSize')]
    #[Assert\Image(
        maxSize: '1000k',
        mimeTypes: ['image/jpeg', 'image/png'],
        maxRatio: '1.75',
        minRatio: '1.70',
        maxSizeMessage: 'Le fichier ne doit pas faire plus de {{ limit }}ko, mais il fait {{ size }}',
        mimeTypesMessage: 'Le fichier doit être au format JPG ou PNG',
    )]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: TechcareClient::class, cascade: ['remove'])]
    private Collection $client;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: TechcareUser::class)]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: TechcareProduct::class, cascade: ['remove'])]
    private Collection $products;

    #[ORM\OneToOne(cascade: ['remove'])]
    private ?TechcareUser $owner = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $CreatedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $CreatedBy = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $UpdatedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $UpdatedBy = null;

    public function __construct()
    {
        $this->client = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->products = new ArrayCollection();
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

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): static
    {
        $this->siret = $siret;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

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
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile): TechcareCompany
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->UpdatedAt = new \DateTime();
        }

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): TechcareCompany
    {
        $this->imageName = $imageName;
        return $this;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function setImageSize(?int $imageSize): TechcareCompany
    {
        $this->imageSize = $imageSize;
        return $this;
    }

    /**
     * @return Collection<int, TechcareClient>
     */
    public function getClient(): Collection
    {
        return $this->client;
    }

    public function addClient(TechcareClient $client): static
    {
        if (!$this->client->contains($client)) {
            $this->client->add($client);
            $client->setCompany($this);
        }

        return $this;
    }

    public function removeClient(TechcareClient $client): static
    {
        if ($this->client->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getCompany() === $this) {
                $client->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TechcareUser>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(TechcareUser $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setCompany($this);
        }

        return $this;
    }

    public function removeUser(TechcareUser $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCompany() === $this) {
                $user->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TechcareProduct>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(TechcareProduct $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setCompany($this);
        }

        return $this;
    }

    public function removeProduct(TechcareProduct $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCompany() === $this) {
                $product->setCompany(null);
            }
        }

        return $this;
    }

    public function getOwner(): ?TechcareUser
    {
        return $this->owner;
    }

    public function setOwner(?TechcareUser $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

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

    public function getCreatedBy(): ?string
    {
        return $this->CreatedBy;
    }

    public function setCreatedBy(string $CreatedBy): static
    {
        $this->CreatedBy = $CreatedBy;

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

    public function getUpdatedBy(): ?string
    {
        return $this->UpdatedBy;
    }

    public function setUpdatedBy(?string $UpdatedBy): static
    {
        $this->UpdatedBy = $UpdatedBy;

        return $this;
    }
}
