<?php
declare(strict_types=1);

namespace Eitol\ColombianCedulaReader;

/**
 * Legal document information
 */
class DocumentInfo
{
    /** @var string */
    private $documentType;
    /** @var string */
    private $documentNumber;
    /** @var string */
    private $afisCode;
    /** @var string */
    private $fingerCard;

    /**
     * @return string
     */
    public function getDocumentType(): string
    {
        return $this->documentType;
    }

    /**
     * @param string $documentType
     */
    public function setDocumentType(string $documentType): void
    {
        $this->documentType = $this->getTypeDocumentStr($documentType);
    }

    /**
     * @return string
     */
    public function getDocumentNumber(): string
    {
        return $this->documentNumber;
    }

    /**
     * @param string $documentNumber
     */
    public function setDocumentNumber(string $documentNumber): void
    {
        $this->documentNumber = $documentNumber;
    }

    /**
     * @return string
     */
    public function getAfisCode(): string
    {
        return $this->afisCode;
    }

    /**
     * @param string $afisCode
     */
    public function setAfisCode(string $afisCode): void
    {
        $this->afisCode = $afisCode;
    }

    /**
     * @return string
     */
    public function getFingerCard(): string
    {
        return $this->fingerCard;
    }

    /**
     * @param string $fingerCard
     */
    public function setFingerCard(string $fingerCard): void
    {
        $this->fingerCard = $fingerCard;
    }


    public function getTypeDocumentStr(string $value): string
    {
        if ($value == 1) {
            return "driver_license";
        } elseif ($value == 2) {
            return "citizen_id";
        }
        return "";
    }
}
