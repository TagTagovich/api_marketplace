<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
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
 *     normalizationContext={"groups"={"price:read"}},
 *     denormalizationContext={"groups"={"price:write"}})
 */
class Price
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="doctrine.uuid_generator")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     * @Groups({"price:write", "price:read"})
     */
    private $oldPrice;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Channel", inversedBy="prices")
     * @Groups({"price:write", "price:read", "product:write"})
     */
    private $channel;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     * @Groups({"price:write", "price:read", "product:write"})
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="prices")
     */
    private $product;

    public function getId()
    {
        return $this->id;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getOldPrice(): ?string
    {
        return $this->oldPrice;
    }

    public function setOldPrice(string $oldPrice): self
    {
        $this->oldPrice = $oldPrice;

        return $this;
    }

    public function getChannel(): ?Channel
    {
        return $this->channel;
    }

    public function setChannel(?Channel $channel): self
    {
        $this->channel = $channel;

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
}
