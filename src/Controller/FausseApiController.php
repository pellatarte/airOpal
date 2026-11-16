<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Une FAUSSE API Open-Meteo, servie par AirOpale lui-même. Fournie : vous
 * n'avez pas à la lire, ni à la modifier.
 *
 * À quoi elle sert : si le réseau de la salle ne laisse pas passer
 * l'API, on met dans .env.local
 *     METEO_URL=http://localhost/fausse-api
 *     AIR_URL=http://localhost/fausse-api
 * et votre code, SANS CHANGER D'UNE LIGNE, interroge cette fausse API.
 * Depuis le conteneur web, « localhost » est le conteneur lui-même :
 * Apache s'appelle lui-même.
 *
 * Elle répond au même format que la vraie (mêmes clés JSON, mêmes unités),
 * avec des valeurs inventées mais stables : mêmes coordonnées et même
 * heure donnent les mêmes valeurs.
 */
class FausseApiController extends AbstractController
{
    #[Route('/fausse-api/v1/forecast', name: 'fausse_api_meteo', methods: ['GET'])]
    public function meteo(Request $request): JsonResponse
    {
        [$latitude, $longitude, $graine] = $this->lireCoordonnees($request);
        $heure = $this->heureCourante(15);

        return $this->json([
            'latitude' => $latitude,
            'longitude' => $longitude,
            'timezone' => 'Europe/Paris',
            'current_units' => [
                'time' => 'iso8601',
                'temperature_2m' => '°C',
                'wind_speed_10m' => 'km/h',
                'weather_code' => 'wmo code',
            ],
            'current' => [
                'time' => $heure,
                'temperature_2m' => round(4 + ($graine % 120) / 10, 1),
                'wind_speed_10m' => round(5 + ($graine % 350) / 10, 1),
                'weather_code' => [0, 1, 2, 3, 45, 61, 63, 80][$graine % 8],
            ],
        ]);
    }

    #[Route('/fausse-api/v1/air-quality', name: 'fausse_api_air', methods: ['GET'])]
    public function air(Request $request): JsonResponse
    {
        [$latitude, $longitude, $graine] = $this->lireCoordonnees($request);
        $heure = $this->heureCourante(60);

        return $this->json([
            'latitude' => $latitude,
            'longitude' => $longitude,
            'timezone' => 'Europe/Paris',
            'current_units' => [
                'time' => 'iso8601',
                'european_aqi' => 'EAQI',
                'pm2_5' => 'μg/m³',
                'pm10' => 'μg/m³',
                'nitrogen_dioxide' => 'μg/m³',
            ],
            'current' => [
                'time' => $heure,
                'european_aqi' => 8 + $graine % 70,
                'pm2_5' => round(2 + ($graine % 300) / 10, 1),
                'pm10' => round(5 + ($graine % 450) / 10, 1),
                'nitrogen_dioxide' => round(3 + ($graine % 400) / 10, 1),
            ],
        ]);
    }

    /**
     * @return array{0: float, 1: float, 2: int}
     */
    private function lireCoordonnees(Request $request): array
    {
        $latitude = (float) $request->query->get('latitude', '0');
        $longitude = (float) $request->query->get('longitude', '0');
        $graine = abs(crc32(sprintf('%.2f|%.2f|%s', $latitude, $longitude, date('Y-m-d H'))));

        return [$latitude, $longitude, $graine];
    }

    private function heureCourante(int $pasEnMinutes): string
    {
        $maintenant = new \DateTimeImmutable();
        $minutes = intdiv((int) $maintenant->format('i'), $pasEnMinutes) * $pasEnMinutes;

        return $maintenant->format('Y-m-d\TH:') . sprintf('%02d', $minutes);
    }
}
