<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Repository\ProductRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: '`product`')]
#[ApiResource(
    operations: [
        new GetCollection(),
    ]
)]
#[ApiResource(
    uriTemplate: '/orders/{id}/products',
    operations: [new GetCollection()],
    uriVariables: [
        'id' => new Link(
            fromProperty: 'products',
            fromClass: Order::class
        )
    ],
    security: "is_granted('IS_AUTHENTICATED_FULLY')"
)]
class Product
{
    #[ORM\Id, ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['product:read'])]
    private Uuid $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['product:read', 'product:write'])]
    private string $name;

    #[ORM\Column(type: 'decimal', scale: 2)]
    #[Groups(['product:read', 'product:write'])]
    private float $price;

    #[ORM\ManyToMany(targetEntity: Order::class, mappedBy: 'products')]
    #[Groups(['product:read', 'product:write'])]
    private Collection $orders;

    #[ORM\Column(name: 'created_at', type: 'datetime')]
    #[Groups(['product:read', 'product:write'])]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime')]
    #[Groups(['product:read', 'product:write'])]
    private DateTime $updatedAt;

    public function __construct()
    {
        $this->id = Uuid::v4();
        $this->orders = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): void
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
        }
    }

    public function removeOrder(Order $order): void
    {
        $this->orders->removeElement($order);
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
