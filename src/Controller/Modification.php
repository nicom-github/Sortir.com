<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Modification extends AbstractController
{
    /**
     * @Route("/", name="app_cretion")
     */
    public function login(): Response
    {
        return $this->render('main/modifier.html.twig');
    }
}