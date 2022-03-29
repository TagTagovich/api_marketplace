<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity()
 * @ApiResource(
 *     normalizationContext={"groups"={"product:read"}},
 *     denormalizationContext={"groups"={"product:write"}})
 * 
 */
class Product
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
     * @Groups({"product:write", "product:read", "category:read"})
     */
    private $name;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"product:write", "product:read"})
     */
    private $sku;

    /**
     * @ORM\Column(type="string", length=255, nullable="true")
     * @Groups({"product:read"})
     */
    private $foreignId;

    /**
     * @ORM\Column(type="text")
     * @Groups({"product:write", "product:read"})
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"product:write", "product:read"})
     */
    private $isActive;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"product:write", "product:read"})
     */
    private $markable;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="products")
     * @Groups({"product:write", "product:read"})
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Photo", mappedBy="product")
     * 
     */
    private $photos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PropertyValue", mappedBy="product")
     * 
     */
    private $propertyValues;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Price", mappedBy="price")
     * 
     */
    private $prices;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SaleStatus", mappedBy="product")
     * 
     */
    private $saleStatuses;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
        $this->propertyValues = new ArrayCollection();
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

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): self
    {
        $this->sku = $sku;

        return $this;
    }

    public function getForeignId(): ?string
    {
        return $this->foreignId;
    }

    public function setForeignId(string $foreignId): self
    {
        $this->foreignId = $foreignId;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getMarkable(): ?bool
    {
        return $this->markable;
    }

    public function setMarkable(bool $markable): self
    {
        $this->markable = $markable;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }
    public function setCategory(?Category $category): self
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return Collection|Photos[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }
    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photos)) {
            $this->photos[] = $photo;
            $photo->setProduct($this);
        }
        return $this;
    }
    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->contains($photos)) {
            $this->photos->removeElement($photo);
            // set the owning side to null (unless already changed)
            if ($photo->getProduct() === $this) {
                $photo->setProduct(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|PropertyValues[]
     */
    public function getPropertyValues(): Collection
    {
        return $this->propertyValues;
    }
    
    public function addPropertyValue(PropertyValue $propertyValue): self
    {
        if (!$this->propertyValues->contains($propertyValues)) {
            $this->propertyValues[] = $propertyValue;
            $propertyValue->setProduct($this);
        }
        return $this;
    }
    
    public function removePropertyValue(PropertyValue $propertyValue): self
    {
        if ($this->propertyValues->contains($propertyValues)) {
            $this->propertyValues->removeElement($propertyValue);
            // set the owning side to null (unless already changed)
            if ($propertyValue->getProduct() === $this) {
                $propertyValue->setProduct(null);
            }
        }
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
        if (!$this->prices->contains($prices)) {
            $this->prices[] = $price;
            $price->setProduct($this);
        }
        return $this;
    }
    public function removePrice(Price $price): self
    {
        if ($this->prices->contains($prices)) {
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
