<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class ClovekData
{
    public function __construct(
        public string $Jmeno,
        public string $Funkce,
        public string $Email,
        public string|null $Telefon,
        public string $Pohlavi,
    )
    {
    }


    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            $data['Jmeno'],
            $data['Funkce'],
            $data['Email'],
            $data['Telefon'],
            $data['Pohlavi'],
        );
    }
}
