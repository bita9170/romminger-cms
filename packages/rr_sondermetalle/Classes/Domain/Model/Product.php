<?php

namespace Romminger\RrSondermetalle\Domain\Model;

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use Romminger\RrSondermetalle\Domain\Model\Material;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;

class Product extends AbstractEntity
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $abstract;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var ObjectStorage<FileReference>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected ObjectStorage $images;

    /**
     * @var string
     */
    protected $salesUnitType;

    /**
     * @var float
     */
    protected $unitPrice;

    /**
     * @var int
     */
    protected $stockQuantity;

    /**
     * @var float
     */
    protected $weight;

    /**
     * @var float
     */
    protected $length;

    /**
     * @var int
     */
    protected $minOrderQuantity;

    /**
     * @var float
     */
    protected $priceBasedOnWeight;

    /**
     * @var float
     */
    protected $priceBasedOnLength;

    /**
     * @var Material
     */
    protected $material;

    /**
     * @var string
     */
    protected $status;

    public function __construct()
    {
        $this->images = new ObjectStorage();
    }

    // Setters and Getters
    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAbstract(): string
    {
        return $this->abstract;
    }

    public function setAbstract(string $abstract): void
    {
        $this->abstract = $abstract;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return ObjectStorage<FileReference>
     */
    public function getImages(): ObjectStorage
    {
        return $this->images;
    }

    /**
     * @param ObjectStorage<FileReference> $images
     */
    public function setImages(ObjectStorage $images): void
    {
        $this->images = $images;
    }

    public function getSalesUnitType(): string
    {
        return $this->salesUnitType;
    }

    public function setSalesUnitType(string $salesUnitType): void
    {
        $this->salesUnitType = $salesUnitType;
    }

    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(float $unitPrice): void
    {
        $this->unitPrice = $unitPrice;
    }

    public function getStockQuantity(): int
    {
        return $this->stockQuantity;
    }

    public function setStockQuantity(int $stockQuantity): void
    {
        $this->stockQuantity = $stockQuantity;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }

    public function getLength(): float
    {
        return $this->length;
    }

    public function setLength(float $length): void
    {
        $this->length = $length;
    }

    public function getMinOrderQuantity(): int
    {
        return $this->minOrderQuantity;
    }

    public function setMinOrderQuantity(int $minOrderQuantity): void
    {
        $this->minOrderQuantity = $minOrderQuantity;
    }

    public function getPriceBasedOnWeight(): float
    {
        return $this->priceBasedOnWeight;
    }

    public function setPriceBasedOnWeight(float $priceBasedOnWeight): void
    {
        $this->priceBasedOnWeight = $priceBasedOnWeight;
    }

    public function getPriceBasedOnLength(): float
    {
        return $this->priceBasedOnLength;
    }

    public function setPriceBasedOnLength(float $priceBasedOnLength): void
    {
        $this->priceBasedOnLength = $priceBasedOnLength;
    }

    public function getMaterial(): Material
    {
        return $this->material;
    }

    public function setMaterial(Material $material): void
    {
        $this->material = $material;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
