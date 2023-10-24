<?php

namespace App\Controller;

use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModificationController extends AbstractController
{
    /**
     * @Route("/modifier{id}", name="app_modifier")
     */
    public function modification(
        int $id,
        SortieRepository $sortieRepository
    ): Response
    {
        $sortie = $sortieRepository->find($id);

        return $this->render('modify/modifier.html.twig', [
            'sortie' => $sortie
        ]);
    }
}