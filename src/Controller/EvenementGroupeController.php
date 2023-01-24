<?php

namespace App\Controller;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Evenement;
use App\Entity\Groupe;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
#[ApiResource()]
class EvenementGroupeController extends AbstractController
{
    #[Route('/event/{id_event}/group/{id_group}', name: 'AddEventInGroupe', defaults: ['_api_resource_class' => Groupe::class], methods: ['POST'])]
    /* ajouter un evenement à un groupe */
    public function AddEventInGroupe(Request $request, ManagerRegistry $doctrine)
    {
        $Revent = $doctrine->getRepository(Evenement::class);
        $Rgroup = $doctrine->getRepository(Groupe::class);

        /* Récupère les Ids de l'événement / groupent concerné */
        $event = $Revent->findOneBy(['id' => $request->get('id_event')]);
        $group = $Rgroup->findOneBy(['id' => $request->get('id_group')]);

        if ($event) {
            if ($group) {
                $g = $group->addEvenement($event);
                $doctrine->getManager()->persist($g);
                $doctrine->getManager()->flush();

                return $this->json(['message' => 'Succes : Evenement ajouté au groupe'], 201);
                /* utilise la méthode additivement pour associer un événement à un groupe */
            } else {
                return $this->json(['message' => 'error : Groupe inexistant'], 404);
            }
        } else {
            return $this->json(['message' => 'error : Evenement inexistant'], 404);
        }
    }

    #[Route('/event/{id_event}/group/{id_group}', name: 'DeleteEventInGroupe', defaults: ['_api_resource_class' => Groupe::class], methods: ['DELETE'])]
    public function DeleteEventInGroupe(Request $request, ManagerRegistry $doctrine)
    {
        $Revent = $doctrine->getRepository(Evenement::class);
        $Rgroup = $doctrine->getRepository(Groupe::class);

        // if event are already in group
        $event = $Revent->findOneBy(['id' => $request->get('id_event')]);
        $group = $Rgroup->findOneBy(['id' => $request->get('id_group')]);

        if (!$group->getEvenements()->contains($event)) {
            return $this->json(['message' => "L'evenement n'est pas asssocié à ce groupe"], 404);
        }
        if ($event) {
            if ($group) {
                $group->removeEvenement($event);
                $doctrine->getManager()->persist($group);
                $doctrine->getManager()->flush();

                return $this->json(['message' => 'Succes : Evenement supprimé'], 201);
            } else {
                return $this->json(['message' => 'error : Groupe inexistant'], 404);
            }
        } else {
            return $this->json(['message' => 'error : Evenemennt inexistant'], 404);
        }
    }
}
