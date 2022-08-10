<?php

namespace App\Entity;

use App\Repository\PriceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PriceRepository::class)]
class Price
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $product_id = null;

    #[ORM\Column]
    private ?int $region_id = null;

    #[ORM\Column]
    private ?float $price_purchase = null;

    #[ORM\Column]
    private ?float $price_selling = null;

    #[ORM\Column]
    private ?float $price_discount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductId(): ?int
    {
        return $this->product_id;
    }

    public function setProductId(int $product_id): self
    {
        $this->product_id = $product_id;

        return $this;
    }

    public function getRegionId(): ?int
    {
        return $this->region_id;
    }

    public function setRegionId(int $region_id): self
    {
        $this->region_id = $region_id;

        return $this;
    }

    public function getPricePurchase(): ?float
    {
        return $this->price_purchase;
    }

    public function setPricePurchase(float $price_purchase): self
    {
        $this->price_purchase = $price_purchase;

        return $this;
    }

    public function getPriceSelling(): ?float
    {
        return $this->price_selling;
    }

    public function setPriceSelling(float $price_selling): self
    {
        $this->price_selling = $price_selling;

        return $this;
    }

    public function getPriceDiscount(): ?float
    {
        return $this->price_discount;
    }

    public function setPriceDiscount(float $price_discount): self
    {
        $this->price_discount = $price_discount;

        return $this;
    }
}
