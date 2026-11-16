<?php

namespace App\Controller;

use App\Repository\VilleRepository;
use App\Entity\Ville;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/villes')]
class VilleController extends AbstractController
{
    #[Route('', name: 'ville_liste', methods: ['GET'])]
    public function liste(VilleRepository $villeRepository): Response
    {
        return $this->render('ville/liste.html.twig', [
            'villes' => $villeRepository->findBy([], ['nom' => 'ASC']),
        ]);
    }

    #[Route('/{id}', name: 'ville_fiche', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function fiche(Ville $ville): Response
    {
        return $this->render('ville/fiche.html.twig', [
            'ville' => $ville,
        ]);
    }
}
