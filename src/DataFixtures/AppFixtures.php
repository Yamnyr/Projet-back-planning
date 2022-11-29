<?php

namespace App\DataFixtures;

use App\Factory\EvenementFactory;
use App\Factory\UtilisateurFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $prof = UtilisateurFactory::createMany(3, ['roles' => ['ROLE_PROFESSEUR']]);

        for ($i = 0; $i < 20; ++$i) {
            $even = EvenementFactory::createOne([
            ])->setUtilisateur($prof[rand(0, 2)]->object());
            $manager->persist($even);
        }

        $manager->flush();
    }
}
