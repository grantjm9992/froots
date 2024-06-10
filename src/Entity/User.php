<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[Mapping\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[Mapping\Id]
    #[Mapping\GeneratedValue]
    #[Mapping\Column(type: "integer")]
    private int $id;

    #[Mapping\Column(type: "string", length: 180, unique: true)]
    private string $email;

    #[Mapping\Column(type: "string")]
    private string $password;

    #[Mapping\Column(name: 'created_at', type: "datetime")]
    private \DateTimeInterface $createdAt;

    #[Mapping\Column(name: 'updated_at', type: "datetime")]
    private \DateTimeInterface $updatedAt;

    // Getters and setters for all properties

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials(): void
    {
        // Not needed for JWT authentication
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->getEmail();
    }
}
