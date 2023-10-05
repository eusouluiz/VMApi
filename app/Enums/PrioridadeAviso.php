<?php

namespace App\Enums;

enum PrioridadeAviso: string
{
    use EnumTrait;

    case Baixa = 'baixa';
    case Media = 'media';
    case Alta = 'alta';

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
            PrioridadeAviso::Baixa => 'Baixa',
            PrioridadeAviso::Media => 'Média',
            PrioridadeAviso::Alta  => 'Alta',
        };
    }
}
