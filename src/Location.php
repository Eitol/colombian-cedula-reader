<?php
declare(strict_types=1);

namespace Eitol\ColombianCedulaReader;

/**
 * Geographic location
 */
class Location
{
    /** @var string */
    private $country;
    /** @var string */
    private $department;
    /** @var string */
    private $municipality;
    /** @var string */
    private $departmentCode;
    /** @var string */
    private $municipalityCode;

    /**
     * Location constructor.
     * @param string $country
     * @param string $department
     * @param string $municipality
     * @param string $departmentCode
     * @param string $municipalityCode
     */
    public function __construct(string $country, string $department, string $municipality, string $departmentCode, string $municipalityCode)
    {
        $this->country = $country;
        $this->department = $department;
        $this->municipality = $municipality;
        $this->departmentCode = $departmentCode;
        $this->municipalityCode = $municipalityCode;
    }

    /**
     * @return string
     */
    public function getDepartmentCode(): string
    {
        return $this->departmentCode;
    }

    /**
     * @param string $departmentCode
     */
    public function setDepartmentCode(string $departmentCode): void
    {
        $this->departmentCode = $departmentCode;
    }

    /**
     * @return string
     */
    public function getMunicipalityCode(): string
    {
        return $this->municipalityCode;
    }

    /**
     * @param string $municipalityCode
     */
    public function setMunicipalityCode(string $municipalityCode): void
    {
        $this->municipalityCode = $municipalityCode;
    }


    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }


    /**
     * @return string
     */
    public function getDepartment(): string
    {
        return $this->department;
    }

    /**
     * @param string $department
     */
    public function setDepartment(string $department): void
    {
        $this->department = $department;
    }

    /**
     * @return string
     */
    public function getMunicipality(): string
    {
        return $this->municipality;
    }

    /**
     * @param string $municipality
     */
    public function setMunicipality(string $municipality): void
    {
        $this->municipality = $municipality;
    }

}
