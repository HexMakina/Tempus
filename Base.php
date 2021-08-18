<?php

namespace HexMakina\Tempus;

abstract class Base
{
    public static function format($parm = 'now', $format)
    {
        try {
            $date = new \DateTimeImmutable("$parm");
            return $date->format($format);
        } catch (\Exception $e) {
            return null;
        }
    }
}
