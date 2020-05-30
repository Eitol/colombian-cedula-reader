<?php
declare(strict_types=1);

namespace Eitol\ColombianCedulaReader;

/**
 * Interface IDCardDecoderInterface
 */
interface IDCardDecoderInterface
{
    public function decode(string $imageBuffer): DecodeResult;
}

