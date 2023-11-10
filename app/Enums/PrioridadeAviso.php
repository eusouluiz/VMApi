<?php

namespace App\Enums;

enum PrioridadeAviso: string
{
    use EnumTrait;

    case Baixa = '3';
    case Media = '2';
    case Alta = '1';

    /**
     * Custom labels defined for each enum case.
     *
     * @param self $value
     *
     * @return string
     */
    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::Baixa => 'Baixa',
            self::Media => 'Média',
            self::Alta  => 'Alta',
        };
    }
}
