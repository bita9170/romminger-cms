<?php

namespace Romminger\RrSondermetalle\Domain\Model;

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use Evoweb\SfRegister\Domain\Model\FrontendUserGroup;

/**
 * An extended frontend user with more area
 */
class Customer extends AbstractEntity
{
    protected string $username = '';

    protected string $password = '';

    protected string $name = '';

    protected string $firstName = '';

    protected string $middleName = '';

    protected string $lastName = '';

    protected string $address = '';

    protected string $telephone = '';

    protected string $fax = '';

    protected string $email = '';

    protected string $title = '';

    protected string $zip = '';

    protected string $city = '';

    protected string $country = '';

    protected string $www = '';

    protected string $company = '';

    /**
     * If the account is disabled
     */
    protected bool $disable = false;

    protected string $pseudonym = '';

    /**
     * Gender
     *   1 - mr
     *   2 - mrs
     */
    protected int $gender = 1;

    protected string $language = '';

    /**
     * Code of state/province
     */
    protected string $zone = '';

    protected float $timezone = 0;

    /**
     * Daylight saving time
     */
    protected bool $daylight = false;

    /**
     * Country with static info table code
     */
    protected string $staticInfoCountry = '';

    protected string $mobilephone = '';

    protected ?\DateTime $lastlogin = null;

    protected ?\DateTime $activatedOn = null;

    protected ?\DateTime $dateOfBirth = null;

    /**
     * Sets the usergroups. Keep in mind that the property is called "usergroup"
     * although it can hold several usergroups.
     *
     * @var ?ObjectStorage<FrontendUserGroup>
     */
    protected ?ObjectStorage $usergroup = null;

    /**
     * @var ?ObjectStorage<FileReference>
     */
    protected ?ObjectStorage $image = null;

    public function __construct(string $username = '', string $password = '')
    {
        $this->username = $username;
        $this->password = $password;
        $this->initializeObject();
    }

    public function initializeObject(): void
    {
        $this->usergroup = $this->usergroup ?? new ObjectStorage();
        $this->image = $this->image ?? new ObjectStorage();
    }

    public function getUsergroup(): ObjectStorage
    {
        return $this->usergroup;
    }

    public function getImage(): ObjectStorage
    {
        return $this->image;
    }

    public function getLastlogin(): ?\DateTime
    {
        return $this->lastlogin;
    }

    public function getActivatedOn(): ?\DateTime
    {
        return $this->activatedOn;
    }

    public function getDateOfBirth(): ?\DateTime
    {
        return $this->dateOfBirth;
    }

    public function getTimezone(): float
    {
        return floor($this->timezone) != $this->timezone
            ? $this->timezone * 10
            : $this->timezone;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }


    public function getAddress(): string
    {
        return $this->address;
    }


    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function getFax(): string
    {
        return $this->fax;
    }


    public function getEmail(): string
    {
        return $this->email;
    }


    public function getTitle(): string
    {
        return $this->title;
    }

    public function getZip(): string
    {
        return $this->zip;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getWww(): string
    {
        return $this->www;
    }


    public function getCompany(): string
    {
        return $this->company;
    }

    public function getDisable(): bool
    {
        return $this->disable;
    }


    public function getPseudonym(): string
    {
        return $this->pseudonym;
    }


    public function getGender(): int
    {
        return $this->gender;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function getZone(): string
    {
        return $this->zone;
    }


    public function isDaylight(): bool
    {
        return $this->daylight;
    }


    public function getStaticInfoCountry(): string
    {
        return $this->staticInfoCountry;
    }

    public function getMobilephone(): string
    {
        return $this->mobilephone;
    }

    public function isGtc(): bool
    {
        return $this->gtc;
    }


    public function getStatus(): int
    {
        return $this->status;
    }

    public function isByInvitation(): bool
    {
        return $this->byInvitation;
    }


    public function getComments(): string
    {
        return $this->comments;
    }


    public function isModuleSysDmailNewsletter(): bool
    {
        return $this->moduleSysDmailNewsletter;
    }
}
