<?php

namespace App\WebClients\Bitcoin;

interface IBitcoinWebClient
{
    public function recupererPrixBitcoin(): float;
    public function functionRecupererPrixCrypto(string $crypto): float;
}