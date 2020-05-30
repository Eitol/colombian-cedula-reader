<?php
declare(strict_types=1);

namespace Eitol\ColombianCedulaReader;

/**
 * The result of decoding a code
 */
class DecodeResult
{
    /** @var string */
    private $error;
    /** @var Person */
    private $person;

    /**
     * DecodeResult constructor.
     * @param string $error
     * @param Person $person
     */
    public function __construct(string $error, ?Person $person)
    {
        $this->error = $error;
        $this->person = $person;
    }


    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @param string $error
     */
    public function setError(string $error): void
    {
        $this->error = $error;
    }

    /**
     * @return Person
     */
    public function getPerson(): Person
    {
        return $this->person;
    }

    /**
     * @param Person $person
     */
    public function setPerson(Person $person): void
    {
        $this->person = $person;
    }

}
