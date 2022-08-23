<?php
declare(strict_types=1);

namespace Eitol\ColombianCedulaReader;

use DateTime;

/**
 * Class Person
 */
class Person
{
    /** @var string */
    private $personType;
    /** @var string */
    private $name;
    /** @var DateTime */
    private $birthDay;
    /** @var string */
    private $bloodType;
    /** @var string | "male", "female" or "other" */
    private $gender;
    /** @var Location */
    private $location;
    /** @var DocumentInfo */
    private $documentInfo;

    /**
     * @return DocumentInfo
     */
    public function getDocumentInfo(): DocumentInfo
    {
        return $this->documentInfo;
    }

    /**
     * @param DocumentInfo $documentInfo
     */
    public function setDocumentInfo(DocumentInfo $documentInfo): void
    {
        $this->documentInfo = $documentInfo;
    }

    /**
     * @return string
     */
    public function getPersonType(): string
    {
        return $this->personType;
    }

    /**
     * @param string $personType
     */
    public function setPersonType(string $personType): void
    {
        $this->personType = $personType;
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return DateTime
     */
    public function getBirthDay(): DateTime
    {
        return $this->birthDay;
    }

    /**
     * @param DateTime $birthDay
     */
    public function setBirthDay(DateTime $birthDay): void
    {
        $this->birthDay = $birthDay;
    }

    /**
     * @return string
     */
    public function getBloodType(): string
    {
        return $this->bloodType;
    }

    /**
     * @param string $bloodType
     */
    public function setBloodType(string $bloodType): void
    {
        $this->bloodType = $bloodType;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender(string $gender): void
    {
        if ($gender == "F") {
            $gender = "female";
        } else if ($gender == "M") {
            $gender = "male";
        } else {
            $gender = "other";
        }
        $this->gender = $gender;
    }

    /**
     * @return Location
     */
    public function getLocation(): Location
    {
        return $this->location;
    }

    /**
     * @param Location $location
     */
    public function setLocation(?Location $location): void
    {
        $this->location = $location;
    }

    public function getPersonTypeStr(): string
    {
        if ($this->getPersonType() == 0) {
            return "native";
        } elseif ($this->getPersonType() == 1) {
            return "foreign";
        }
        return "";
    }
}
