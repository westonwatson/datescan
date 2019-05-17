<?php

namespace westonwatson\ContactSourceDateTimeHelper;

use PHPUnit\Framework\TestCase;
use DateTime;

class DateTimeTest extends TestCase {

    const TEST_GOOD_DATE = '2019-03-15';

    /**
     * setUp
     */
    protected function setUp():void
    {
        require_once ('./DateTimeHelper.php');
    }

    /**
     * Test Array of Valid Dates
     * @throws \Exception
     */
    public function testGoodDates()
    {
        $good_dates = [
            date('2301Y'),
            date('0123Y'),
            date('2301y'),
            date('0123y'),
            date('23/01/Y'),
            date('01/23/Y'),
            date('23-01-Y'),
            date('01-23-Y'),
            date('23-01-Y 01:23'),
            date('23-01-Y 01:23:00'),
            date('01-23-Y\T01:23'),
            date('01-23-Y\T01:23:00'),
            date('Y'),
            date('y'),
        ];

        $good_date_min = new DateTime('next year');
        $good_date_max = new DateTime('1 year ago');

        foreach ($good_dates as $good_date) {
            $dateTimeHelper = new DateTimeHelper($good_date);
            $real_date = $dateTimeHelper->getRealDateTime();
            $this->assertLessThan($real_date, $good_date_max);
            $this->assertGreaterThan($real_date, $good_date_min);
        }
    }

    /**
     * Test Array of Invalid Dates
     * @throws \Exception
     */
    public function testBadDates()
    {
        $bad_dates = [
            'bad',
            'never',
            0,
        ];

        foreach ($bad_dates as $bad_date) {
            $dateTimeHelper = new DateTimeHelper($bad_date);
            $this->assertNull($dateTimeHelper->getRealDateTime());
        }
    }

    /**
     * Test Custom Regex Pattern and Date Format
     * @throws \Exception
     */
    public function testCustomFormatPattern()
    {
        $dateTimeHelper = new DateTimeHelper('-2018-');
        $dateTimeHelper->addFormatPattern('-Y-', '/^-[0-9]{4}-$/');

        $this->assertEquals((date_create_from_format('Y', '2018')), $dateTimeHelper->getRealDateTime());
    }

    /**
     * Test Duplicate Regex Pattern Exception
     * @throws \Exception
     */
    public function testDuplicatePattern()
    {
        $this->expectException(\Exception::class);

        $dateTimeHelper = new DateTimeHelper(self::TEST_GOOD_DATE);
        $dateTimeHelper->addFormatPattern('dmY', '/^(0[1-9]|[1-2][0-9]|3[0-1])(0[1-9]|1[0-2])[0-9]{4}$/');
    }

    /**
     * Test Adding a Custom Closest Date
     */

    public function testCustomClosestDate()
    {
        $newClosestDate = new DateTime('2000-01-01');

        $dateTimeHelper = new DateTimeHelper('01-01-01');
        $dateTimeHelper->setClosestDate($newClosestDate);

        $realDate = $dateTimeHelper->getRealDateTime();

        $this->assertEquals('2001-01-01', $realDate->format('Y-m-d'));
    }

}
