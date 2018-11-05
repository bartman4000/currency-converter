<?php
/**
 * @author Bartłomiej Olewiński <bartlomiej.olewinski@gmail.com>
 */

namespace App\Service;


interface ExchangeClientInterface
{
    public function getRate(string $from, string $to): float;
}