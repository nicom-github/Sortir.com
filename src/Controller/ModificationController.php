<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\AnnulerSortieType;
use App\Form\ModifSortieType;
use App\Repository\LieuRepository;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModificationController extends AbstractController
{
    /**
     * @Route("/modifier{id}", name="app_modifier")
     */
    public function modification(
        int $id,
        SortieRepository $sortieRepository,
        Request $request,
        EntityManagerInterface $entityManager,
        VilleRepository $villeRepository,
        LieuRepository $lieuRepository
    ): Response
    {
        $sortie = $sortieRepository->find($id);
        $lieux = $lieuRepository->findLieu();
        $villes = $villeRepository->findAll();
        $campus = $this->getUser()->getCampus();
        $user = $this->getUser();
        $sortie->setOrganisateur($user);

        $form = $this->createForm(ModifSortieType::class, $sortie);
        $form->handleRequest($request);

        // Vérification du formulaire
        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager->persist($sortie);
            $entityManager->flush();
            // do anything else you need here, like send an email

            //Message d'info
            $request
                ->getSession()
                ->getFlashBag()
                ->add(
                    'modificationSortie',
                    'La nouvelle sortie a bien été modifiée.'
                );

            return $this->redirectToRoute('app_modifier',array(
                'id' =>$id));
        }else{

            $string = (string) $form->getErrors(true, false);

            dump($form);
            //Message d'info
            $request
                ->getSession()
                ->getFlashBag()
                ->add(
                    'modificationSortie',
                    'Erreur : Modification de la sortie :' && $string
                );
        }

        return $this->render('modify/modifier.html.twig', [
            'creationsortie' => $form -> createView(),
            'lieux'=> $lieux,
            'campus'=>$campus,
            'villes'=>$villes,
            'sortieId'=>$id

        ]);
    }

    /**
     * @Route("/annulerSortie{id}", name="app_annulerSortie")
     */
    public function annuler(
        int $id,
        SortieRepository $sortieRepository,
        Request $request,
        EntityManagerInterface $entityManager,
        VilleRepository $villeRepository,
        LieuRepository $lieuRepository

    ): Response
    {

        $sortie = $sortieRepository->find($id);
        $lieux = $lieuRepository->findLieu();
        $villes = $villeRepository->findAll();
        $campus = $this->getUser()->getCampus();
        $user = $this->getUser();
        $sortie->setOrganisateur($user);

        $form = $this->createForm(AnnulerSortieType::class, $sortie);
        $form->handleRequest($request);


        return $this->render('annuler/annuler.html.twig', [
            'annulationsortie' => $form -> createView(),
            'lieux'=> $lieux,
            'campus'=>$campus,
            'villes'=>$villes,
            'sortieId'=>$id,
            'sortie'=>$sortie

        ]);

    }

    /**
     * @Route("/suppressionSortie{id}", name="app_supprimerSortie")
     */
    public function suppression(
        int $id,
        SortieRepository $sortieRepository
    )
    {
        $sortie = $sortieRepository->find($id);
        $sortieRepository->remove($sortie);
        return $this->redirectToRoute('app_main_index');

    }


    /**
     * @Route("/inscriptionSortie{id}", name="app_inscriptionSortie")
     */
    public function inscription(
        int $id,
        SortieRepository $sortieRepository
    )
    {
        $sortie = $sortieRepository->find($id);
        //$participant->addInscription($sortie);
        return $this->redirectToRoute('app_afficher_sortie',array(
            'id' =>$id));

    }


    /**
     * @Route("/seDesisterSortie{id}", name="app_seDesisterSortie")
     */
    public function seDesister(
        int $id,
        SortieRepository $sortieRepository
    )
    {
        //$participant->getUserIdentifier($this->getUser()->getUserIdentifier());
        $sortie = $sortieRepository->find($id);
        $this->getUser()->removeInscription($sortie);
        return $this->redirectToRoute('app_afficher_sortie',array(
            'id' =>$id));

    }

    /**
     * @Route("/publierSortie{id}", name="app_publierSortie")
     */
    public function publier(
        int $id,
        SortieRepository $sortieRepository

    )
    {

        $sortie = $sortieRepository->find($id);
        //$sortie->setEtat($etat->getId(1));
        return $this->redirectToRoute('app_afficher_sortie',array(
            'id' =>$id));

    }


}