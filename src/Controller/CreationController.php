<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\CreationSortieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreationController extends AbstractController
{
    /**
     * @Route("/creation", name="app_creation")
     */
    public function creation(Request $request): Response
    {
        $sortie = new Sortie();
        $creationsortieForm =  $this ->createForm(CreationSortieType::class, $sortie);

        // TO DO traiter le formulaire

        return $this->render('main/creationsortie.html.twig', [
            'creationsortie' => $creationsortieForm -> createView() ]);
    }

}
