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
 *           }
 *     },
 * 
 *     normalizationContext={"groups"={"product:read"}},
 *     denormalizationContext={"groups"={"product:write"}})
 * 
 */
class SaleStatus
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="doctrine.uuid_generator")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="saleStatuses")
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Channel", inversedBy="saleStatuses")
     * @Groups({"saleStatus:write", "saleStatus:read", "product:write"})
     */
    private $channel;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"saleStatus:write", "saleStatus:read", "product:write"})
     */
    private $isSale;


    public function getId()
    {
        return $this->id;
    }

    public function getIsSale(): ?bool
    {
        return $this->isSale;
    }

    public function setIsSale(bool $isSale): self
    {
        $this->isSale = $isSale;

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
