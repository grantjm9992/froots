<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\OrderRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[ApiResource(
    operations: [
        new GetCollection(),
    ]
)]
class Order
{
    #[ORM\Id, ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['order:read'])]
    private Uuid $id;

    #[ORM\Column(name: 'amount', type: 'decimal', scale: 2)]
    #[Groups(['order:read', 'order:write'])]
    private float $amount;

    #[ORM\Column(name: 'created_at', type: 'datetime')]
    #[Groups(['order:read', 'order:write'])]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime')]
    #[Groups(['order:read', 'order:write'])]
    private DateTime $updatedAt;

    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'orders')]
    #[Groups(['order:read', 'order:write'])]
    private Collection $products;

    public function __construct()
    {
        $this->id = Uuid::v4();
        $this->products = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
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

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): void
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
        }
    }

    public function setProducts(Collection $products): void
    {
        $this->products = $products;
    }
}
