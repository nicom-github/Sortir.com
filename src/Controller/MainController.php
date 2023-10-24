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
     * @Route("/", name="app_main_index")
     */
    public function index(
        Request $request,
        SortieRepository $sortieRepository,
        CampusRepository $campusRepository

    ): Response
    {

        //Appel SearchData
        $data = new SearchData();
        $data->campus =$this->getUser()->getCampus();
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);

        //va chercher les infos en bdd
        $sorties = $sortieRepository->findSearch($data,$this->getUser());


        return $this->render('main/index.html.twig', [
            "sorties"=>$sorties,
            'SearchForm' => $form->createView()
        ]);
    }



}
