<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiFilter;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Elasticsearch\DataProvider\Filter\OrderFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;



/**
 * @ApiResource(
 *     normalizationContext={"groups"={"category:read"}},
 *     denormalizationContext={"groups"={"category:write"}})
 * @ORM\Entity()
 */
class Category
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
     * @Groups({"category:write", "category:read"})
     * 
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Groups({"category:write", "category:read"})
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"category:write", "category:read"})
     */
    private $isActive;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="category")
     * #Groups({"category:write", "category:read"})
     */
    private $products;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="children")
     * @Groups({"category:write", "category:read"})
     * @ApiProperty(readableLink=true)
     */
    private $parent;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Category", mappedBy="parent")
     * @Groups({"category:read"})
     */
    private $children;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    public function getId(): ?uuid
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

    /**
     * @return Collection|Products[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }
    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setCategory($this);
        }
        return $this;
    }
    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }
        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(Category $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(Category $child): self
    {
        if ($this->children->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    } 
}
