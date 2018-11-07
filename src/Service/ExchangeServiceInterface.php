<?php
/**
 * @author Bartłomiej Olewiński <bartlomiej.olewinski@gmail.com>
 */

namespace App\Service;

interface ExchangeServiceInterface
{
    public function exchange(string $from, string $to, float $amount): float;

    public function getBaseUri(): string;
}
