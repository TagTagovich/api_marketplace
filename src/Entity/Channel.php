<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ApiResource()
 */
class Channel
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="doctrine.uuid_generator")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"catalog:write", "catalog:read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"catalog:write", "catalog:read"})
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Price", mappedBy="channel")
     */
    private $prices;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SaleStatus", mappedBy="channel")
     */
    private $saleStatuses;

    public function __construct()
    {
        $this->prices = new ArrayCollection();
        $this->saleStatuses = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Prices[]
     */
    public function getPrices(): Collection
    {
        return $this->prices;
    }
    public function addPrice(Price $price): self
    {
        if (!$this->prices->contains($price)) {
            $this->prices[] = $price;
            $price->setProduct($this);
        }
        return $this;
    }
    public function removePrice(Price $price): self
    {
        if ($this->prices->contains($price)) {
            $this->prices->removeElement($price);
            // set the owning side to null (unless already changed)
            if ($price->getProduct() === $this) {
                $price->setProduct(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|SaleStatuses[]
     */
    public function getSaleStatuses(): Collection
    {
        return $this->saleStatuses;
    }
    public function addSaleStatus(SaleStatus $saleStatus): self
    {
        if (!$this->saleStatuses->contains($saleStatuses)) {
            $this->saleStatuses[] = $saleStatus;
            $saleStatus->setChannel($this);
        }
        return $this;
    }
    public function removeSaleStatus(SaleStatus $saleStatus): self
    {
        if ($this->saleStatuses->contains($saleStatuses)) {
            $this->saleStatuses->removeElement($saleStatus);
            // set the owning side to null (unless already changed)
            if ($saleStatus->getChannel() === $this) {
                $saleStatus->setChannel(null);
            }
        }
        return $this;
    }
}
