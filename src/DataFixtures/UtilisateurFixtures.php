<?php

namespace App\DataFixtures;

use App\Factory\UtilisateurFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UtilisateurFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UtilisateurFactory::createMany(5, ['roles' => ['ROLE_ELEVE']]);
        UtilisateurFactory::createMany(3, ['roles' => ['ROLE_PROFESSEUR']]);
        UtilisateurFactory::createMany(2, ['roles' => ['ROLE_ADMINISTRATEUR']]);

        $manager->flush();
    }
}
