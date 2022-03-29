<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ApiResource()
 */
class Property
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
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"catalog:write", "catalog:read"})
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PropertyValue", mappedBy="property")
     */
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

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
            $propertyValue->setProperty($this);
        }
        return $this;
    }
    
    public function removePropertyValue(PropertyValue $propertyValue): self
    {
        if ($this->propertyValues->contains($propertyValues)) {
            $this->propertyValues->removeElement($propertyValue);
            // set the owning side to null (unless already changed)
            if ($propertyValue->getProperty() === $this) {
                $propertyValue->setProperty(null);
            }
        }
        return $this;
    }

}
