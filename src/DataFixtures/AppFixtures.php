<?php

namespace App\DataFixtures;

use App\Entity\Ville;
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
        $villes = [
            ['Calais', 50.9513, 1.8587],
            ['Boulogne-sur-Mer', 50.7264, 1.6147],
            ['Dunkerque', 51.0344, 2.3768],
            ['Saint-Omer', 50.7500, 2.2522],
            ['Lille', 50.6292, 3.0573],
        ];

        foreach ($villes as [$nom, $latitude, $longitude]) {
            $ville = new Ville();
            $ville->setNom($nom)
                ->setLatitude($latitude)
                ->setLongitude($longitude);

            $manager->persist($ville);
        }

        $manager->flush();
    }
}
