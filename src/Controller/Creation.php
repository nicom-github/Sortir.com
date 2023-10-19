<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Creation extends AbstractController
{
    /**
     * @Route("/", name="app_creation")
     */
    public function login(): Response
    {
        return $this->render('main/creation.html.twig');
    }
}