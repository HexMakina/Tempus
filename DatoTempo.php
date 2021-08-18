<?php

namespace HexMakina\Tempus;

class DatoTempo extends Dato
{
  const FORMAT = 'Y-m-d H:i:s';

  public static function format($parm=null, $format=null)
  {
    return parent::format($parm, $format ?? self::FORMAT);
  }

}


