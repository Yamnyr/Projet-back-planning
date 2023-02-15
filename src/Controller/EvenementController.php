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
class EvenementController extends AbstractController
{

}
