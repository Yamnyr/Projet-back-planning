<?php

namespace App\Controller;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Evenement;
use App\Entity\Groupe;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManager;
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
    $lib_groupe = $request->get('lib_groupe');
    $date_start = $request->get('date_start');
    $date_end = $request->get('date_end');
    
    if($lib_groupe){
      // $evenements = $evenementRepository->findByIntervaleAndGroupe($date_start, $date_end, $lib_groupe, EntityManager::class);

      $entityManager = $this->getDoctrine()->getManager();

      // Récupérer le repository (la classe qui gère les requêtes) pour l'entité Evenement
      $evenementRepository = $entityManager->getRepository(Evenement::class);

      // Récupérer le repository pour l'entité Groupe
      $groupeRepository = $entityManager->getRepository(Groupe::class);

      // Récupérer tous les événements associés à un groupe avec un libellé spécifique
      $evenements = $evenementRepository->createQueryBuilder('e')
          ->join('e.concerne', 'g')
          ->where('g.lib_groupe LIKE :libelle')
          ->andWhere('e.date >= :date_start')
          ->andWhere('e.date <= :date_end')
          ->setParameter('libelle', "%". $lib_groupe . "%")
          ->setParameter('date_start', $date_start)
          ->setParameter('date_end', $date_end)
          ->getQuery()
          ->getResult();

    }else{
      $evenements = $evenementRepository->findByIntervale($date_start, $date_end);
    }

    // if(!$evenements){
    //   return $this->json(['message' => 'Aucun evenement trouvé'], 404);
    // }

    return $this->json([$evenements], 200);
  }

}
