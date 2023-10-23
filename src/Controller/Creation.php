<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\CreationSortieType;
use App\Repository\CampusRepository;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Creation extends AbstractController
{
    /**
     * @Route("/", name="app_creation")
     */
    public function creation(Request $request): Response
    {
        $creationsortie = new CreationSortieType();
        $creationsortieForm =  $this ->createForm(Sortie::class, $creationsortie);

        // TO DO traiter le formulaire

        return $this->render('main/creationsortie.html.twig', [
            'creationsortie' => $creationsortieForm -> createView() ]);
    }

}
