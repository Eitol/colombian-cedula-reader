<?php


namespace Eitol\ColombianCedulaReader;


/**
 * Class ColombianIDCardDecoderOptions
 */
class ColombianIDCardDecoderOptions
{
    /** @var string */
    public $javaPath;

    public function createDefault()
    {
        $this->javaPath = "";
    }

    /**
     * @return string
     */
    public function getJavaPath(): string
    {
        return $this->javaPath;
    }

    /**
     * @param string $javaPath
     */
    public function setJavaPath(string $javaPath): void
    {
        $this->javaPath = $javaPath;
    }
}
