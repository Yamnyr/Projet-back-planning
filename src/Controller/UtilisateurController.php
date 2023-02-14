<?php

namespace App\Controller;

use ApiPlatform\Metadata\ApiResource;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;

#[Route('/api')]
#[ApiResource()]
class UtilisateurController extends AbstractController
{
    #[Route('/user/me', name: 'Me', methods: ['GET'])]
    public function Me()
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        // return response with user data
        return $this->json($user, 200);
    }
}
