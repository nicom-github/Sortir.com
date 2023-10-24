<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\RegistrationFormType;
use App\Repository\CampusRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/admin/register", name="app_register")
     */
    public function register(
        Request $request,

        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager,
        CampusRepository $campusRepository
    ): Response
    {
        //va chercher infos en bdd
        $campus = $campusRepository->findCampus();

        $user = new Participant();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        // Vérification du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setMotPasse(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            //Message d'info
            $request
                ->getSession()
                ->getFlashBag()
                ->add(
                    'ajouteParticipant',
                    'Le participant a bien été ajouté, vous pouvez en créer un autre'
                );

            return $this->redirectToRoute('app_register');
        }else{

            $string = (string) $form->getErrors(true, false);

            dump($form);
            //Message d'info
            $request
                ->getSession()
                ->getFlashBag()
                ->add(
                    'ajouteParticipant',
                    'Erreur : Enregistrement du participant :' && $string
                );
        }

        return $this->render('registration/register.html.twig', [
            'info'=>$form->getErrors(),
            'registrationForm' => $form->createView(),
            "campus"=>$campus
        ]);
    }


}
