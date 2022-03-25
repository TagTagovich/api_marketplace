<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ApiResource(
 *     normalizationContext={"groups"={"catalog:read"}},
 *     denormalizationContext={"groups"={"catalog:write"}})
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
     * @ORM\Column(type="boolean")
     * @Groups({"catalog:write", "catalog:read"})
     */
    private $isSale;

    private $product;

    public function getId(): ?int
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
}
