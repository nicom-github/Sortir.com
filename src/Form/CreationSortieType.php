<?php

namespace App\Form;


use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CreationSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('dateHeureDebut', DateTimeType::class, [
                'html5' => true,
            ])
            ->add('duree', NumberType::class)
            ->add('dateLimiteInscription', DateType::class)
            ->add('nbInscriptionsMax', NumberType::class)

            ->add('infosSortie', TextareaType::class)
            ->add('lieu', EntityType::class, ['class'=> Lieu::class , 'choice_label'=> "nom"])
            ->add('campus', EntityType::class,
                ['class' => campus::class, 'choice_label' => 'nom'
                ])

       # ->add('ville',EntityType::class) # #TO DO dans un second temps #
                 ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
