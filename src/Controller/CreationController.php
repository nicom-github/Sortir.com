<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Ville;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Form\CreationSortieType;
use App\Repository\LieuRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreationController extends AbstractController
{
    /**
     * @Route("/creation", name="app_creation")
     */
    public function creation(
        Request $request,
        EntityManagerInterface $entityManager,
        VilleRepository $villeRepository,
        LieuRepository $lieuRepository
    ): Response
    {

        $lieux = $lieuRepository->findLieu();

        $user = $this->getUser();


        $sortie = new Sortie();
        $sortie->setOrganisateur($user);
        //$sortie->setEtat();

        $creationsortieForm =  $this ->createForm(CreationSortieType::class, $sortie);
        $creationsortieForm->handleRequest($request);

// Vérification du formulaire
        if ($creationsortieForm->isSubmitted() && $creationsortieForm->isValid()) {


            $entityManager->persist($sortie);
            $entityManager->flush();
            // do anything else you need here, like send an email

            //Message d'info
            $request
                ->getSession()
                ->getFlashBag()
                ->add(
                    'creationSortie',
                    'La nouvelle sortie a bien été créée, vous pouvez en créer un autre'
                );

            return $this->redirectToRoute('app_creation');
        }else{

            $string = (string) $creationsortieForm->getErrors(true, false);

            dump($creationsortieForm);
            //Message d'info
            $request
                ->getSession()
                ->getFlashBag()
                ->add(
                    'creationSortie',
                    'Erreur : Enregistrement de la sortie :' && $string
                );
        }


        return $this->render('create/creationsortie.html.twig', [
            'creationsortie' => $creationsortieForm -> createView(),
           'lieux'=> $lieux

        ]);
    }

}
