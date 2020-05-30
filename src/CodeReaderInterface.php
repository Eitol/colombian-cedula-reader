<?php
declare(strict_types=1);

namespace Eitol\ColombianCedulaReader;

use PHPZxing\PHPZxingDecoder;

/**
 * Interface CodeReaderInterface
 */
interface CodeReaderInterface
{
    /**
     * Returns the information of some code of the image
     *
     * @param string $imageBuffer The image raw data
     * @return string Return and string with the image data.
     * For example, if the image has a PDF417 code, it decodes
     * it and returns the information contained in it.
     */
    public static function readCodeFromImg(string $imageBuffer): string;
}