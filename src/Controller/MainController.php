<?php

namespace App\Controller;

use App\data\SearchData;
use App\Form\SearchForm;
use App\Repository\CampusRepository;
use App\Repository\SortieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    /**
     * @Route("/index", name="app_main_index")
     */
    public function index(
        Request $request,
        SortieRepository $sortieRepository,
        CampusRepository $campusRepository

    ): Response
    {

        //Appel SearchData
        $data = new SearchData();
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);

        //va chercher les infos en bdd
        $campus = $campusRepository->findCampus();
        $sorties = $sortieRepository->findSearch($data);

        return $this->render('main/index.html.twig', [
            "sorties"=>$sorties,
            "campus"=>$campus,
            'SearchForm' => $form->createView()
        ]);
    }



}
