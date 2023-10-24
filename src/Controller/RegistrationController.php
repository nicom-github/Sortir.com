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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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

    public function registerCSV(
        EntityManagerInterface $em,
        UserPasswordHasherInterface $userPasswordHasher,
        $data)
    {

        //Vérif
        if (count($data) == 0 || count($data) == 1 || is_null($data)) {
            $this->addFlash('success', 'Aucun membre dans la liste à insérer');
            return $this->redirectToRoute('app_register');
        }

        //Suppréssion de la premiere ligne
        $newParticipants = array_slice($data, 1);

        $errors = array();

        foreach ($newParticipants as $participant) {

            $nom = $participant[0];
            $prenom = $participant[1];
            $pseudo = $participant[2];
            $email = $participant[3];
            $campus = $participant[4];

            //Check si le membre existe deja dans la base de données (email seulement car pas de pseudo encore)
            if ($em->getRepository(Participant::class)->findByEmail($email)) {
                //Existe déjà:
                $errors[] = ['member' => $participant, 'msg' => $email. ': email existe déjà dans la base, il n\'a pas été inséré.'];
                continue;
            }

            // Création du participant
            $user = new Participant();
            $user->setNom($nom);
            $user->setPrenom($prenom);
            $user->setPseudo($pseudo);
            $user->setEmail($email);
            $user->setCampus($campus);
            $plainPassword = $nom+$prenom+$pseudo;
            $user->setMotPasse($userPasswordHasher->hashPassword(
                    $user,
                $plainPassword
                )
            );
            $user->setActif(true);

            //Persist:
            $em->persist($user);
            $this->addFlash('error', $nom . ' : inscrit avec succès !');
        }

        $em->flush();
        dump($errors);

        foreach ($errors as $error){
            $this->addFlash('error', $error['msg']);
        }

        return $this->redirectToRoute('app_register');

    }


}
