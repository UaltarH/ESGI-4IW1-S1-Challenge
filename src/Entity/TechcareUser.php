<?php

namespace App\Entity;

use App\Repository\TechcareUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\InheritanceType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TechcareUserRepository::class)] #[InheritanceType('JOINED')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class TechcareUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    protected ?Uuid $id = null;

    #[ORM\Column(length: 180, unique: true)]
    protected ?string $email = null;

    #[ORM\Column]
    protected array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    protected ?string $password = null;

    #[ORM\Column(length: 50)]
    protected ?string $firstname = null;

    #[ORM\Column(length: 50)]
    protected ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $createdBy = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $updatedBy = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    protected ?TechcareCompany $company = null;

    // GETTERS AND SETTERS
    public function getId(): ?Uuid
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getCompany(): ?TechcareCompany
    {
        return $this->company;
    }

    public function setCompany(?TechcareCompany $company): static
    {
        $this->company = $company;

        return $this;
    }

    // Custome Gettters
    public function getRolesAsString(): string
    {
        $rolesWithoutUser = array_diff($this->getRoles(), ['ROLE_USER']);
        foreach ($rolesWithoutUser as $key => $role) {
            if ($role === 'ROLE_ADMIN') {
                $rolesWithoutUser[$key] = 'Administrateur';
            }
            if ($role === 'ROLE_CLIENT') {
                $rolesWithoutUser[$key] = 'Client';
            }
            if ($role === 'ROLE_ENTREPRISE') {
                $rolesWithoutUser[$key] = 'Emplayer entreprise';
            }
            if ($role === 'ROLE_OWNER_ENTREPRISE') {
                $rolesWithoutUser[$key] = 'Propriétaire entreprise';
            }
            if ($role === 'ROLE_COMPTABLE') {
                $rolesWithoutUser[$key] = 'Comptable';
            }
        }
        return implode(', ', $rolesWithoutUser);
    }
}
