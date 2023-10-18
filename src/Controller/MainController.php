<?php

namespace App\Controller;

use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_login")
     */
    public function login(): Response
    {
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/", name="app_main_index")
     */
    public function index(SortieRepository $sortieRepository): Response
    {
        //va chercher toutes les Sorties en bdd
        $sorties = $sortieRepository->findSortie();

        //Test si le user est inscrit dans des sorties

        return $this->render('main/index.html.twig', [
            "sorties"=>$sorties
        ]);
    }



}
