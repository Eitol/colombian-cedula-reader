<?php
declare(strict_types=1);
namespace Eitol\ColombianCedulaReader\Tests;

use Eitol\ColombianCedulaReader\ColombianIDCardDecoder;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Assert;

/**
 * Class ColombianIDCardDecoderTest
 * @package IDCardDecoder
 */
class ColombianIDCardDecoderTest extends TestCase
{
    const TEST_DATA_PATH = "testdata";

    /**
     * @var string[]
     */
    const TEST_FILES = [
        "best_quality_1",
    ];

    public function testDecode()
    {
        $decoder = new ColombianIDCardDecoder();
        foreach (self::TEST_FILES as $test_file) {

            $txt_file = file_get_contents("tests". DIRECTORY_SEPARATOR . self::TEST_DATA_PATH . DIRECTORY_SEPARATOR . $test_file . ".jpg");
            $result = $decoder->decode($txt_file);
            print_r(json_encode($result));
            Assert::assertEmpty($result->getError());
        }
    }
}
