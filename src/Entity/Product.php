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
 *     normalizationContext={"groups"={"catalog:read"}},
 *     denormalizationContext={"groups"={"catalog:write"}})
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
     * @Groups({"catalog:write", "catalog:read"})
     */
    private $name;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"catalog:write", "catalog:read"})
     */
    private $sku;

    /**
     * @ORM\Column(type="string", length=255, nullable="true")
     * @Groups({"catalog:read"})
     */
    private $foreignId;

    /**
     * @ORM\Column(type="text")
     * @Groups({"catalog:write", "catalog:read"})
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"catalog:write", "catalog:read"})
     */
    private $isActive;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"catalog:write", "catalog:read"})
     */
    private $markable;

    private $category;

    private $photos;

    private $propertyValues;

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

}
