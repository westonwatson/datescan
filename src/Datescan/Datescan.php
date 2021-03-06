<?php

namespace westonwatson\Datescan;

use DateTime;

/**
 * Class Datescan
 *
 * @package westonwatson\datescan
 */
class Datescan
{
    const DUPLICATE_PATTERN_ERROR  = "This Regular Expression Already Exists\n";

    /**
     * @var DateTime
     */
    private $closestDate;

    /**
     * @var
     */
    private $inputDate = '';

    /**
     * @var array
     */
    private $formatPatterns = [
        '/^(0[1-9]|[1-2][0-9]|3[0-1])(0[1-9]|1[0-2])[0-9]{4}$/'                                                                       => 'dmY',
        '/^(0[1-9]|[1-2][0-9]|3[0-1])(0[1-9]|1[0-2])[0-9]{2}$/'                                                                       => 'dmy',
        '/^(0[1-9]|1[0-2])(0[1-9]|[1-2][0-9]|3[0-1])[0-9]{2}$/'                                                                       => 'mdy',
        '/^(0[1-9]|1[0-2])(0[1-9]|[1-2][0-9]|3[0-1])[0-9]{4}$/'                                                                       => 'mdY',
        '/^[0-9]{4}(0[1-9]|1[0-2])(0[1-9]|[1-2][0-9]|3[0-1])$/'                                                                       => 'Ymd',
        '/^[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|[1-2][0-9]|3[0-1])$/'                                                                       => 'ymd',
        '/^(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])\/[0-9]{4}$/'                                                                   => 'm/d/Y',
        '/^(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])\/[0-9]{2}$/'                                                                   => 'm/d/y',
        '/^(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])-[0-9]{4}$/'                                                                     => 'm-d-Y',
        '/^(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])-[0-9]{2}$/'                                                                     => 'm-d-y',
        '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/'                                                                     => 'Y-m-d',
        '/^[0-9]{4}\/(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])$/'                                                                   => 'Y/m/d',
        '/^[0-9]{2}\/(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])$/'                                                                   => 'y/m/d',
        '/^[0-9]{2}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/'                                                                     => 'y-m-d',
        '/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/'                                                                     => 'd-m-Y',
        '/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{2}$/'                                                                     => 'd-m-y',
        '/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{2}$/'                                                                   => 'd/m/y',
        '/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{4}$/'                                                                   => 'd/m/Y',
        '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])T([0-2][0-9]):([0-6][0-9]):([0-6][0-9])[+-]([0-2][0-9]):([0-6][0-9])$/' => 'Y-m-d\TH:i:s',
        '/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{4} ([0-2][0-9]):([0-6][0-9])$/'                                         => 'd/m/Y H:i',
        '/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{4} ([0-2][0-9]):([0-6][0-9]):([0-6][0-9])$/'                            => 'd/m/Y H:i:s',
        '/^(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])\/[0-9]{4} ([0-2][0-9]):([0-6][0-9])$/'                                         => 'm/d/Y H:i',
        '/^(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])\/[0-9]{4} ([0-2][0-9]):([0-6][0-9]):([0-6][0-9])$/'                            => 'm/d/Y H:i:s',
        '/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4} ([0-2][0-9]):([0-6][0-9])$/'                                           => 'd-m-Y H:i',
        '/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4} ([0-2][0-9]):([0-6][0-9]):([0-6][0-9])$/'                              => 'd-m-Y H:i:s',
        '/^(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])-[0-9]{4} ([0-2][0-9]):([0-6][0-9])$/'                                           => 'm-d-Y H:i',
        '/^(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])-[0-9]{4} ([0-2][0-9]):([0-6][0-9]):([0-6][0-9])$/'                              => 'm-d-Y H:i:s',
        '/^(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])-[0-9]{4}T([0-2][0-9]):([0-6][0-9]):([0-6][0-9])$/'                              => 'm-d-Y\TH:i:s',
        '/^(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])-[0-9]{4}T([0-2][0-9]):([0-6][0-9])$/'                                           => 'm-d-Y\TH:i',
        '/^([0-9]{2})$/'                                                                                                              => 'y',
        '/^[12][0-9]{3}$/'                                                                                                            => 'Y',
    ];

    /**
     * @var array
     */
    private $dates = [];

    /**
     * @var array
     */
    private $datesAndDiffs = [];

    /**
     * Datescan constructor.
     *
     * @param $inputDate
     *
     * @throws \Exception
     */
    public function __construct($inputDate)
    {
        $this->closestDate = new DateTime();

        if (!empty($inputDate) || strlen($inputDate) > 0) {
            $this->inputDate = $inputDate;
        } else {
            $this->inputDate = null;
        }

    }

    /**
     * @param $dateFormat
     * @param $regexPattern
     *
     * @return mixed|array
     * @throws \Exception
     */
    public function addFormatPattern($dateFormat, $regexPattern)
    {
        if (array_key_exists($regexPattern, $this->formatPatterns)) {
            throw new \Exception(self::DUPLICATE_PATTERN_ERROR.$regexPattern);
        }

        return $this->formatPatterns[$regexPattern] = $dateFormat;
    }

    /**
     * @param DateTime $closestDate
     */
    public function setClosestDate(DateTime $closestDate)
    {
        $this->closestDate = $closestDate;
    }

    /**
     * @return mixed
     */
    public function getRealDateTime()
    {
        $this->findPatternsAndParseDates();

        return $this->findBestDate();
    }

    /**
     * Parse dates with all matching Patterns/Formats
     */
    private function findPatternsAndParseDates()
    {
        foreach ($this->formatPatterns as $pattern => $format) {
            if (preg_match($pattern, $this->inputDate)) {
                $parsed = $this->parseDate($format, $this->inputDate);
                if ($parsed != false) {
                    array_push($this->dates, $parsed);
                }
            }
        }
    }

    /**
     * @return mixed
     */
    private function findBestDate()
    {
        $dateDiffs = [];

        foreach ($this->dates as $date) {
            if ($dateDiff = $this->dateDiff($date)) {
                $diff = abs(intval($dateDiff->format('%R%a')));
                array_push($dateDiffs, $diff);
                $this->datesAndDiffs[$diff] = $date;
            }
        }

        if (count($dateDiffs) < 1) {
            try {
                $actualDate = new DateTime($this->inputDate);
            } catch (\Exception $exception) {
                $actualDate = null;
            }
        } else {
            asort($dateDiffs);
            $actualDate = $this->datesAndDiffs[reset($dateDiffs)];
        }

        return $actualDate;
    }

    /**
     * @param $format
     * @param $date
     *
     * @return DateTime|false
     */
    private function parseDate($format, $date)
    {
        return DateTime::createFromFormat($format, $date);
    }

    /**
     * @param DateTime $date
     *
     * @return \DateInterval|false
     */
    private function dateDiff(DateTime $date)
    {
        return $this->closestDate->diff($date);
    }

}
