<?php

namespace App\Controller;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Groupe;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
#[ApiResource()]
class GroupeController extends AbstractController
{
    #[Route('/group/{this_id_groupe}/group/{in_id_groupe}', name: 'CreateGroupeinGroupe', defaults: ['_api_resource_class' => Groupe::class], methods: ['PUT'])]
    public function CreateGroupeinGroupe(Request $request, ManagerRegistry $doctrine)
    {
        $Rgroup = $doctrine->getRepository(Groupe::class);

        $Groupe_parent = $Rgroup->findOneBy(['id' => $request->get('in_id_groupe')]);
        $Groupe_child = $Rgroup->findOneBy(['id' => $request->get('this_id_groupe')]);

        if ($Groupe_parent) {
            if ($Groupe_child) {
                $Groupe_parent->addGroupe($Groupe_child);
                $doctrine->getManager()->persist($Groupe_parent);
                $doctrine->getManager()->flush();

                return $this->json(['message' => 'Succes : Groupe ajouté'], 201);
            } else {
                return $this->json(['message' => 'error : Groupe enfant inexistant'], 404);
            }
        } else {
            return $this->json(['message' => 'error : Groupe parent inexistant'], 404);
        }
    }

    #[Route('/groupe/me', name: 'GetUserGroupe', defaults: ['_api_resource_class' => Groupe::class], methods: ['GET'])]
    public function GetUserGroupe(Request $request)
    {
        $user = $this->getUser();


        if(in_array('ROLE_ADMINISTRATEUR', $user->getRoles()) OR in_array('ROLE_PROFESSEUR', $user->getRoles())){
            $groupe = $this->getDoctrine()->getRepository(Groupe::class)->findAll();
            return $this->json($groupe, 200);
        }


        if(in_array('ROLE_ELEVE', $user->getRoles())){
            // all groupe contain this user
            $groupes = $this->getDoctrine()->getRepository(Groupe::class)->findAll();
            $result = [];
            foreach($groupes as $groupe){
                if($groupe->getUtilisateurs()->contains($user)){
                    $result[] = $groupe;
                }
            }

            return $this->json($result, 200);
        }

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }
        return $this->json(['message' => 'error : Utilisateur non trouvé'], 404);
    }

}
