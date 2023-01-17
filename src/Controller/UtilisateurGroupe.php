<?php

namespace App\Controller;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Groupe;
use App\Entity\Utilisateur;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
#[ApiResource()]
class UtilisateurGroupe extends AbstractController
{
    #[Route('/user/{id_user}/group/{id_group}', name: 'AddUserInGroupe', defaults: ['_api_resource_class' => Groupe::class], methods: ['POST'])]
    public function AddUserInGroupe(Request $request, ManagerRegistry $doctrine)
    {
        $Ruser = $doctrine->getRepository(Utilisateur::class);
        $Rgroup = $doctrine->getRepository(Groupe::class);
        $user = $Ruser->findOneBy(['id' => $request->get('id_user')]);
        $group = $Rgroup->findOneBy(['id' => $request->get('id_group')]);

        if (!$user) {
            return $this->json(['message' => 'error : Utilisateur inexistant'], 404);
        }
        if ($group) {
            $g = $group->addUtilisateur($user);
            $doctrine->getManager()->persist($g);
            $doctrine->getManager()->flush();

            return $this->json(['message' => 'Succes : Utilisateur ajouté'], 201);
        } else {
            return $this->json(['message' => 'error : Groupe inexistant'], 404);
        }
    }

    #[Route('/user/{id_user}/group/{id_group}', name: 'DeleteUserInGroupe', defaults: ['_api_resource_class' => Groupe::class], methods: ['DELETE'])]
    public function DeleteUserInGroupe(Request $request, ManagerRegistry $doctrine)
    {
        $Ruser = $doctrine->getRepository(Utilisateur::class);
        $Rgroup = $doctrine->getRepository(Groupe::class);

        // if user are already in group
        $user = $Ruser->findOneBy(['id' => $request->get('id_user')]);
        $group = $Rgroup->findOneBy(['id' => $request->get('id_group')]);

        if (!$group->GetUtilisateurs()->contains($user)) {
            return $this->json(['message' => "L'utilisateur ne fait pas parti du groupe"], 404);
        }
        if ($user) {
            if ($group) {
                $group->removeUtilisateur($user);
                $doctrine->getManager()->persist($group);
                $doctrine->getManager()->flush();

                return $this->json(['message' => 'Succes : Utilisateur supprimé'], 201);
            } else {
                return $this->json(['message' => 'error : Groupe inexistant'], 404);
            }
        } else {
            return $this->json(['message' => 'error : Utilisateur inexistant'], 404);
        }
    }
}
