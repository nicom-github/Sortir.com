<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\File;

class ProfilFormtType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class,['label' => 'Pseudo : ',])
            ->add('prenom', TextType::class,['label' => 'Prénom : ',])
            ->add('nom', TextType::class,['label' => 'Nom : ',])
            ->add('telephone', TextType::class,['label' => 'Téléphone : ',])
            ->add('email', TextType::class,['label' => 'Email : ',])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'label' => false,
                'invalid_message' => 'Les mots de passe ne sont pas identiques.',
                'mapped' => false,
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => false,
                'first_options'  => ['label' => 'Password : '],
                'second_options' => ['label' => 'Repeat Password : '],
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])

            ->add('campus', EntityType::class,
                [
                    'class' => campus::class,
                    'label' => 'Campus : ',
                    'choice_label' => 'nom'
                ])

            //Ajout photo
            ->add('image', FileType::class, [
                    'label' => 'Ma photo : ',
                    'mapped' => false,
                    'required' => false,
                    'constraints' => [
                        new File([
                            'maxSize' => '2048k',
                            'mimeTypes' => [
                                'image/jpg',
                                'image/jpeg',
                                'image/png',
                            ],
                            'mimeTypesMessage' => 'Veuillez fournir un fichier sous format JPG ou PNG',
                            'maxSizeMessage' => 'Veuillez charger un fichier de taille inférieure à 2Mo'
                        ])
                    ],
                ]
            )
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
