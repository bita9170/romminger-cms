<?php

namespace Romminger\RrSondermetalle\Domain\Model;

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Category extends AbstractEntity
{
    protected string $name = '';
    protected string $description = '';

    /**
     * @var Category|null
     */
    protected $parentCategory = null;

    /**
     * @var ObjectStorage<Category>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $subCategories;

    /**
     * @var ObjectStorage<FileReference>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected ObjectStorage $images;


    public function __construct()
    {
        $this->subCategories = new ObjectStorage();
        $this->images = new ObjectStorage();
    }

    // Getters and setters
    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getParentCategory(): ?Category
    {
        return $this->parentCategory;
    }

    public function getSubCategories(): ObjectStorage
    {
        return $this->subCategories;
    }

    public function setSubCategories(ObjectStorage $subCategories): void
    {
        $this->subCategories = $subCategories;
    }

    public function addSubCategory(Category $category): void
    {
        $this->subCategories->attach($category);
    }

    public function removeSubCategory(Category $category): void
    {
        $this->subCategories->detach($category);
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
