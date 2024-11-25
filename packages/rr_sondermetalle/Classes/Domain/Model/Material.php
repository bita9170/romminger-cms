<?php

namespace Romminger\RrSondermetalle\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;


class Material extends AbstractEntity
{
    protected string $id = '';
    protected string $name = '';
    protected string $abstract = '';
    protected int $atomicNumber = 0;
    protected string $atomicWeight = '';
    protected string $symbol = '';
    protected string $description = '';

    /**
     * @var ObjectStorage<FileReference>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected ObjectStorage $images;

    public function __construct()
    {
        $this->images = new ObjectStorage();
    }

    // Getters and setters
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

    public function getAtomicNumber(): int
    {
        return $this->atomicNumber;
    }

    public function setAtomicNumber(int $atomicNumber): void
    {
        $this->atomicNumber = $atomicNumber;
    }

    public function getAtomicWeight(): string
    {
        return $this->atomicWeight;
    }

    public function setAtomicWeight(string $atomicWeight): void
    {
        $this->atomicWeight = $atomicWeight;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): void
    {
        $this->symbol = $symbol;
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
}
