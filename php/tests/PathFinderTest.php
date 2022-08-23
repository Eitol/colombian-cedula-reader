<?php
declare(strict_types=1);

namespace Eitol\ColombianCedulaReader\Tests;

use Eitol\ColombianCedulaReader\PathFinder\JavaPathFinder;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * Class JavaPathFinderTest
 */
class PathFinderTest extends TestCase
{
    public function testFindPath()
    {
        $finder = new JavaPathFinder();
        $actual = $finder->findPath();
        Assert::assertNotEquals("", $actual, "");
    }
}
