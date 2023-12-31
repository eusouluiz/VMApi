<?php

namespace App\Enums;

enum TipoUser: string
{
    use EnumTrait;

    case Responsavel = 'R';
    case Funcionario = 'F';
    case Ambos = 'A';

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
            TipoUser::Responsavel => 'Responsável',
            TipoUser::Funcionario => 'Funcionário',
            TipoUser::Ambos       => 'Ambos',
        };
    }
}
