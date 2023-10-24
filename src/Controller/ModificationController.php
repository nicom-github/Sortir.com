<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModificationController extends AbstractController
{
    /**
     * @Route("/modifier", name="app_modifier")
     */
    public function login(): Response
    {
        return $this->render('modify/modifier.html.twig');
    }
}