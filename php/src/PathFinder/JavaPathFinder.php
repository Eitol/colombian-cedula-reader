<?php
declare(strict_types=1);

namespace Eitol\ColombianCedulaReader\PathFinder;

/**
 * Allows to search the paths of java binaries
 */
class JavaPathFinder extends PathFinder
{
    /** @var string */
    private static $cachedPath = "";

    public function getUnixPaths(): iterable
    {
        return [
            // Linux
            '/usr/bin/java',
            '/usr/lib/java/bin/java',
            '/usr/share/java/bin/java',
            '/usr/local/bin/java',
            '/usr/local/java/bin/java',
            '/usr/local/java/share/bin/java',
            '/usr/java/j2sdk1.4.2_04/java',
            '/usr/lib/j2sdk*/bin/java',
            '/usr/java/j2sdk*/bin/java',
            '/usr/lib/j2sdk*/bin/java',
            '/opt/sun-jdk-*/bin/java',
            '/usr/local/jdk-*/bin/java',
            // Mac
            "/Library/Java/JavaVirtualMachines/jdk*.jdk/Contents/Home/bin/java",
        ];
    }

    public function getWindowsPaths(): iterable
    {
        return [
            "C:\Program Files\Java\jdk*\bin\java",
            "C:\Windows\Sun\Java\bin\java",
        ];
    }

    public function getCache(): string
    {
        return JavaPathFinder::$cachedPath;
    }

    public function setCache(string $val): void
    {
        JavaPathFinder::$cachedPath = $val;
    }
}