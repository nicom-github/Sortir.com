<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ProfilFormtType;
use App\Repository\CampusRepository;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="app_profil")
     */
    public function profil(Request $request,
     ParticipantRepository $participantRepository,
     UserPasswordHasherInterface $userPasswordHasher,
     EntityManagerInterface  $entityManager,
      CampusRepository  $campusRepository,
                           SluggerInterface $slugger
    ): Response
    {

        $user = $this->getUser();

        //va chercher infos en bdd
        $campus = $campusRepository->findCampus();

        $form = $this->createForm(ProfilFormtType::class, $user);
        $form->handleRequest($request);

        // Vérification du formulaire
        if ($form->isSubmitted() && $form->isValid()) {

            // Ajout de la photo
            $image= $form->get('image')->getData();

            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();
                try {
                    $image->move(
                        $this->getParameter('img_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $user->setImage($newFilename);
            }

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            //Message d'info
            $request
                ->getSession()
                ->getFlashBag()
                ->add(
                    'modifParticipant',
                    'Votre profil a bien été modifié.'
                );

            return $this->redirectToRoute('app_profil');
        }else{

            $string = (string) $form->getErrors(true, false);

            dump($form);
            //Message d'info
            $request
                ->getSession()
                ->getFlashBag()
                ->add(
                    'modifParticipant',
                    'Erreur : Enregistrement du profil :' && $string
                );
        }

        return $this->render('profil/profil.html.twig', [
            'controller_name' => 'ProfilController',
            'profilForm' => $form->createView(),
            'user'=>$user,
             "campus"=>$campus
        ]);
    }

}
