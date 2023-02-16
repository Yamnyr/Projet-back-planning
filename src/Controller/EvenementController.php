<?php

namespace App\Controller;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Evenement;
use App\Repository\EvenementRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
#[ApiResource()]
class EvenementController extends AbstractController
{

  
  #[Route('/evenements/start/{date_start}/end/{date_end}', name: 'GetEvenementIntervale', defaults: ['_api_resource_class' => Evenement::class], methods: ['GET'])]
  public function GetEvenementIntervale(Request $request, EvenementRepository $evenementRepository)
  {
    $date_start = $request->get('date_start');
    $date_end = $request->get('date_end');
    
    
    $evenements = $evenementRepository->findByIntervale($date_start, $date_end);
    
    if(!$evenements){
      return $this->json(['message' => 'Aucun evenement trouvé'], 404);
    }

    return $this->json(['message' => $evenements], 200);

  }

}
