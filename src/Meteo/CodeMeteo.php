<?php

namespace App\Meteo;

/**
 * Traduit le « code WMO » renvoyé par Open-Meteo (weather_code) en libellé.
 * Fourni : c'est une table de correspondance, pas un exercice.
 *
 * Source : la table « WMO Weather interpretation codes » de la
 * documentation d'Open-Meteo.
 */
final class CodeMeteo
{
    private const LIBELLES = [
        0 => 'Ciel dégagé',
        1 => 'Plutôt dégagé',
        2 => 'Partiellement nuageux',
        3 => 'Couvert',
        45 => 'Brouillard',
        48 => 'Brouillard givrant',
        51 => 'Bruine légère',
        53 => 'Bruine',
        55 => 'Bruine dense',
        56 => 'Bruine verglaçante',
        57 => 'Bruine verglaçante dense',
        61 => 'Pluie faible',
        63 => 'Pluie',
        65 => 'Pluie forte',
        66 => 'Pluie verglaçante',
        67 => 'Pluie verglaçante forte',
        71 => 'Neige faible',
        73 => 'Neige',
        75 => 'Neige forte',
        77 => 'Grains de neige',
        80 => 'Averses faibles',
        81 => 'Averses',
        82 => 'Averses violentes',
        85 => 'Averses de neige',
        86 => 'Fortes averses de neige',
        95 => 'Orage',
        96 => 'Orage avec grêle',
        99 => 'Orage avec forte grêle',
    ];

    public static function libelle(int $code): string
    {
        return self::LIBELLES[$code] ?? 'Code météo inconnu (' . $code . ')';
    }
}
