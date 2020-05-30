<?php
declare(strict_types=1);

namespace Eitol\ColombianCedulaReader\PathFinder;

/**
 * Lets you search for paths within the file system
 */
abstract class PathFinder
{
    /**
     * @return bool true if the operating system is windows.
     */
    public static function isWindows()
    {
        return DIRECTORY_SEPARATOR === '\\';
    }

    abstract public function getUnixPaths(): iterable;

    abstract public function getWindowsPaths(): iterable;

    abstract public function getCache(): string;

    abstract public function setCache(string $val): void;

    public function findPath(): string
    {
        if ($this->getCache() != null && $this->getCache() != "") {
            return $this->getCache();
        }
        $array_to_use = $this->getUnixPaths();
        if (PathFinder::isWindows()) {
            $array_to_use = $this->getWindowsPaths();
        }
        foreach ($array_to_use as $possible_path) {
            $matches = glob($possible_path);
            if (count($matches) != 0) {
                $this->setCache($possible_path);
                return $possible_path;
            }
        }
        return "";
    }
}