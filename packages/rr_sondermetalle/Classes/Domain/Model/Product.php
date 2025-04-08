<?php

namespace Romminger\RrSondermetalle\Domain\Model;

use JsonSerializable;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use Romminger\RrSondermetalle\Domain\Model\Material;

class Product extends AbstractEntity implements JsonSerializable
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
     * @var Material
     */
    protected $material;

    /**
     * @var Category
     */
    protected $category;

    /**
     * @var string
     */
    protected $salesUnitType;

    /**
     * @var float
     */
    protected $unitPrice;

    /**
     * @var float|null
     */
    protected $thickness;

    /**
     * @var float|null
     */
    protected $width;

    /**
     * @var float|null
     */
    protected $diameter;

    /**
     * @var float|null
     */
    protected $outerDiameter;

    /**
     * @var float|null
     */
    protected $wallThickness;

    /**
     * @var float|null
     */
    protected $length;

    /**
     * @var int|null
     */
    protected $minOrderQuantity;

    /**
     * @var float|null
     */
    protected $priceBasedOnWeight;

    /**
     * @var float|null
     */
    protected $priceBasedOnLength;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string|null
     */
    protected $quality = null;


    /**
     * @var string
     */
    protected $json;

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

    public function getMaterial(): Material
    {
        return $this->material;
    }

    public function setMaterial(Material $material): void
    {
        $this->material = $material;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
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

    public function getThickness(): ?float
    {
        return $this->thickness;
    }

    public function setThickness(?float $thickness): void
    {
        $this->thickness = $thickness;
    }

    public function getWidth(): ?float
    {
        return $this->width;
    }

    public function setWidth(?float $width): void
    {
        $this->width = $width;
    }

    public function getDiameter(): ?float
    {
        return $this->diameter;
    }

    public function setDiameter(?float $diameter): void
    {
        $this->diameter = $diameter;
    }

    public function getOuterDiameter(): ?float
    {
        return $this->outerDiameter;
    }

    public function setOuterDiameter(?float $outerDiameter): void
    {
        $this->outerDiameter = $outerDiameter;
    }

    public function getWallThickness(): ?float
    {
        return $this->wallThickness;
    }

    public function setWallThickness(?float $wallThickness): void
    {
        $this->wallThickness = $wallThickness;
    }

    public function getLength(): ?float
    {
        return $this->length;
    }

    public function setLength(?float $length): void
    {
        $this->length = $length;
    }

    public function getMinOrderQuantity(): ?int
    {
        return $this->minOrderQuantity;
    }

    public function setMinOrderQuantity(?int $minOrderQuantity): void
    {
        $this->minOrderQuantity = $minOrderQuantity;
    }

    public function getPriceBasedOnWeight(): ?float
    {
        return $this->priceBasedOnWeight;
    }

    public function setPriceBasedOnWeight(?float $priceBasedOnWeight): void
    {
        $this->priceBasedOnWeight = $priceBasedOnWeight;
    }

    public function getPriceBasedOnLength(): ?float
    {
        return $this->priceBasedOnLength;
    }

    public function setPriceBasedOnLength(?float $priceBasedOnLength): void
    {
        $this->priceBasedOnLength = $priceBasedOnLength;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getQuality(): ?string
    {
        return $this->quality;
    }

    public function setQuality(?string $quality): void
    {
        $this->quality = $quality;
    }


    public function getJson(): string
    {
        return $this->json;
    }

    public function setJson(string $json): void
    {
        $this->json = $json;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'material' => $this->material,
            'thickness' => $this->thickness,
            'width' => $this->width,
            'diameter' => $this->diameter,
            'outerDiameter' => $this->outerDiameter,
            'wallThickness' => $this->wallThickness,
            'length' => $this->length,
        ];
    }
    public function getSalesUnitTypeTranslationKey(): string
    {
        return 'product.sales_unit_type.' . $this->salesUnitType;
    }
}
