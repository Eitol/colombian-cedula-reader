<?php


namespace Eitol\ColombianCedulaReader;



use Eitol\ColombianCedulaReader\PathFinder\JavaPathFinder;
use PHPZxing\PHPZxingDecoder;

/**
 * Lets you read images with PDF417 codes
 */
class PDF417CodeReader implements CodeReaderInterface
{
    /** @var string */
    private static $javaPath = "";

    private static function getJavaPath(): string
    {
        return (new JavaPathFinder())->findPath();
    }

    public static function readCodeFromImg(string $img_buffer): string
    {
        $tmp_file = tmpfile();
        $image_path = stream_get_meta_data($tmp_file)['uri'];
        fwrite($tmp_file, $img_buffer);
        $config = array(
            'try_harder'            => true,
            "multiple_bar_codes" => false,
            "possible_formats" => "PDF_417"
        );
        $decoder = new PHPZxingDecoder($config);
        $decoder->setJavaPath(self::getJavaPath());
        $data = $decoder->decode($image_path);

        fclose($tmp_file);
        if ($data != null && $data->isFound()) {
            return $data->getImageValue();
        }
        return "";
    }
}
