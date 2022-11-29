<?php

namespace App\DataFixtures;

use App\Factory\EvenementFactory;
use App\Factory\GroupeFactory;
use App\Factory\UtilisateurFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UtilisateurFactory::createMany(2, ['roles' => ['ROLE_ADMINISTRATEUR']]);
        $eleve = UtilisateurFactory::createMany(5, ['roles' => ['ROLE_ELEVE']]);
        $prof = UtilisateurFactory::createMany(3, ['roles' => ['ROLE_PROFESSEUR']]);

        for ($i = 0; $i < 20; ++$i) {
            $even = EvenementFactory::createOne([
            ])->setUtilisateur($prof[rand(0, 2)]->object());
            $manager->persist($even);
        }
        $manager->flush();

        $grpinfo = GroupeFactory::createOne(['lib_groupe' => 'Dept. Informatique']);
        $grpwim = GroupeFactory::createOne(['lib_groupe' => 'LP-WIMSI'])->setGroupeParent($grpinfo->object());
        $grpA = GroupeFactory::createOne(['lib_groupe' => 'groupe A'])->setGroupeParent($grpwim)
            ->addUtilisateur($prof[0]->object())
            ->addUtilisateur($eleve[3]->object())
            ->addUtilisateur($eleve[4]->object());
        $grpB = GroupeFactory::createOne(['lib_groupe' => 'groupe B'])->setGroupeParent($grpwim)
            ->addUtilisateur($prof[1]->object())
            ->addUtilisateur($eleve[0]->object())
            ->addUtilisateur($eleve[1]->object())
            ->addUtilisateur($eleve[2]->object());

        $manager->flush();

    }
}
