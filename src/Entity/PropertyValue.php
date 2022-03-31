<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


/**
 * @ORM\Entity()
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={
 *          "get"={},
 *          "put",
 *          "patch"={
 *             "input_formats"={
 *                 "jsonld"={
 *                     "application/merge-patch+json",
 *                 },
 *             },
 *          }
 *     },
 *     normalizationContext={"groups"={"propertyValue:read"}},
 *     denormalizationContext={"groups"={"propertyValue:write"}})
 */
class PropertyValue
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="doctrine.uuid_generator")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="propertyValues")
     * @Groups({"propertyValue:read"})
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Property", inversedBy="propertyValues")
     * @Groups({"propertyValue:write", "propertyValue:read", "product:write"})
     * 
     */
    private $property;

    /**
     * @ORM\Column(type="text")
     * @Groups({"propertyValue:write", "propertyValue:read", "product:write", "product:read"})
     * 
     */
    private $value;

    public function getId()
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): self
    {
        $this->property = $property;

        return $this;
    }
}
