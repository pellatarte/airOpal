<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Les « fixtures » : le jeu de données de départ de l'application.
 * Lancé par  php bin/console doctrine:fixtures:load
 * (qui VIDE d'abord les tables, puis exécute load()).
 *
 * À compléter à l'étape A3 du TP.
 */
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // A3 : créer les cinq villes, les confier à Doctrine (persist)…

        // … puis tout écrire en base, en une fois.
        $manager->flush();
    }
}
