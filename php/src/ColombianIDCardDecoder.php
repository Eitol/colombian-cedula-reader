<?php
declare(strict_types=1);

namespace Eitol\ColombianCedulaReader;

use ArrayObject;
use DateTime;


/**
 * Lets read the PDF417 code of the Colombian identity cards
 */
class ColombianIDCardDecoder implements IDCardDecoderInterface
{
    /** @var ColombianIDCardDecoderOptions */
    private $options;

    /**
     * ColombianIDCardDecoder constructor.
     * @param ColombianIDCardDecoderOptions $options
     */
    public function __construct(ColombianIDCardDecoderOptions $options = null)
    {
        $this->options = $options;
    }


    /** Decode the PDF417 code of the Colombian ID
     * @param string $imageBuffer
     * @return DecodeResult
     */
    public function decode(string $imageBuffer): DecodeResult
    {
        if ($imageBuffer == "") {
            return new DecodeResult("the buffer is empty", null);
        }
        $data = PDF417CodeReader::readCodeFromImg($imageBuffer);
        if ($data != "") {
            $person = $this->processData($data);
            return new DecodeResult("", $person);
        }
        return new DecodeResult("unable to read the pdf417 code", null);
    }


    private static function cleanName(string $name): string
    {
        for ($index = 0; $index < strlen($name); $index++) {
            if ((ord($name[$index]) == 0) ||
                (ord($name[$index]) < 65 || (ord($name[$index]) > 90 &&
                        ord($name[$index]) < 97) || ord($name[$index]) > 122)) {
                $name[$index] = ' ';
            }
        }
        return trim(preg_replace('/[\s]+/mu', ' ', $name));
    }

    private function processData(string $data): Person
    {
        $person = new Person();
        $array_data = $this->parseData($data)->getArrayCopy();
        $doc_info = new DocumentInfo();
        $doc_info->setAfisCode(substr($array_data[0], 2, strlen($array_data[0])));
        $doc_info->setFingerCard($array_data[4]);
        $doc_info->setDocumentNumber($array_data[6]);
        $doc_info->setDocumentType($array_data[12]);
        $person->setDocumentInfo($doc_info);
        $person->setName(self::cleanName($array_data[7]));
        $person->setPersonType($array_data[8]);
        $person->setGender($array_data[9]);
        $person->setBirthDay($this->parseDate(substr($array_data[10], 0, 8)));
        $person->setBloodType($array_data[11]);
        $mun_code = substr($array_data[10], 8, 2);
        $dep_code = substr($array_data[10], 10, 3);
        $person->setLocation(Localities::getLocalityByCode($dep_code, $mun_code));
        return $person;
    }

    private function parseDate(string $date): DateTime
    {
        $year = (int)substr($date, 0, 4);
        $month = (int)substr($date, 4, 2);
        $day = (int)substr($date, 6, 2);
        $new_date = new DateTime();
        $new_date->setDate($year, $month, $day);
        return $new_date;
    }


    private function parseData(string $data): ArrayObject
    {
        $last_character = "";
        $token = "";
        $parsed_data = new ArrayObject([]);

        if ($data == null || $data == '') {
            return $parsed_data;
        }

        for ($index = 0; $index < strlen($data); $index++) {
            if ($index == 0) {
                $last_character = $data[$index];
                $token .= $data[$index];
            } else {
                if ((is_numeric($last_character) && is_numeric($data[$index])) || (!is_numeric($last_character) && !is_numeric($data[$index]))) {
                    $token .= $data[$index];
                } else {
                    $parsed_data->append($token);
                    $token = "";
                    $token .= $data[$index];
                }
                $last_character = $data[$index];
            }
        }
        return $parsed_data;
    }


}
