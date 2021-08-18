<?php

namespace HexMakina\Tempus;

class Dato extends Base
{
    const FORMAT = 'Y-m-d';
    const FORMAT_YEAR = 'Y';

    const DAYS_IN_A_WEEK = 7;
    const WEEKS_IN_A_MONTH = 4;
    const MONTHES_IN_A_YEAR = 12;


    public static function format($parm = null, $format = null)
    {
        $format = $format ?? self::FORMAT;
        return parent::format($parm, $format);
    }

    public static function today($format = null)
    {
        $format = $format ?? self::FORMAT;
        return parent::format(null, $format);
    }

    // find the total numbers of days in full years since the mythical 1/1/0001, then add the number of days before the current one in the year passed. Do this for each date, then return the absolute value of the difference
    public static function days_diff($a, $b, $c = 'DateTime')
    {
        if (!is_a($a, $c) || !is_a($b, $c)) {
            throw new \InvalidArgumentException('ARGUMENT_MUST_HAVE_SAME_TYPE');
        }
        return self::days($a) - self::days($b);
    }

    public static function days($x, $d = 0)
    {
        $lfy = $x->format('Y') - 1; // last full year

        foreach ([4, -100, 400] as $f) { // leap year factors
            $d += ($lfy / $f);
        }

        return (int)(($lfy * 365.25) + $d + $x->format('z')); // days since 1.1.1001 from last year (+|-) leap days + days in current year
    }

    public static function days_diff_in_parts($amount_of_days)
    {
        $date_diff = [];

        $previous_part = 'd';

        foreach (['w' => self::DAYS_IN_A_WEEK, 'm' => self::WEEKS_IN_A_MONTH, 'y' => self::MONTHES_IN_A_YEAR] as $part => $limit) {
            if ($amount_of_days >= $limit) {
                $date_diff[$part] = intval($amount_of_days / $limit);
                $date_diff[$previous_part] = $amount_of_days % $limit;
                $previous_part = $part;
                $amount_of_days = intval($amount_of_days / $limit);
            } else {
                $date_diff[$previous_part] = $amount_of_days;
                break;
            }
        }

        return $date_diff;
    }

    public static function first_date($year, $month, $format = null)
    {
        $format = $format ?? self::FORMAT;
        return date_format(new \DateTime("$year-$month-1"), $format);
    }

    public static function last_date($year, $month, $format = null)
    {
        $format = $format ?? self::FORMAT;
        return date_format(new \DateTime("$year-$month-" . self::last_day($year, $month)), $format);
    }

    public static function last_day($year, $month)
    {
        return date_format(new \DateTime("$year-$month-1"), 't');
    }
}
