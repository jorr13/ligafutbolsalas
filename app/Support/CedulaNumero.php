<?php

namespace App\Support;

class CedulaNumero
{
    public const MAX_DIGITOS = 8;

    /**
     * Solo dígitos, máximo 8 (sin puntos ni otros caracteres).
     */
    public static function soloDigitosMax8(?string $valor): string
    {
        return substr(preg_replace('/\D/', '', (string) $valor), 0, self::MAX_DIGITOS);
    }
}
