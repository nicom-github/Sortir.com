<?php

namespace App\Controller;

use App\Repository\CampusRepository;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AfficherSortieController extends AbstractController
{
    /**
     * @Route("/sortie{id}", name="app_afficher_sortie")
     */
    public function index(
     int $id,
     SortieRepository $sortieRepository,
        ParticipantRepository $participantRepository

    ): Response
    {

        //Va chercher les information de la series en bdd
        $sortie = $sortieRepository->find($id);
        $users = $participantRepository->find($id);

        return $this->render('sortie/afficherSortie.html.twig', [
            'controller_name' => 'AfficherSortieController',
            'sortie'=>$sortie,
            'users'=>$users
        ]);
    }
}
