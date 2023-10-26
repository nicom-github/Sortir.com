<?php

namespace App\Form;


use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Entity\Ville;
use App\Repository\LieuRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CreationSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('dateHeureDebut', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
                'label' => false,

            ])
            ->add('dateLimiteInscription', DateType::class, [
                'widget' => 'single_text',
                'label' => false,
                'required' => false,


            ])
            ->add('duree', NumberType::class)
            ->add('nbInscriptionsMax', NumberType::class)
            ->add('infosSortie', TextareaType::class)
            ->add('campus', EntityType::class,
                ['class' => campus::class, 'choice_label' => 'nom'
                ])
            ->add('lieu', EntityType::class,
                ['class' => Lieu::class, 'choice_label' => 'nom'
                ])

            ->add('etat', EntityType::class,
                ['class' => Etat::class,

                    'query_builder' => function (EntityRepository $er): QueryBuilder {
                        return $er->createQueryBuilder('s')
                            ->andWhere('s.libelle = :val')
                            ->setParameter('val', 'Créée');
                    },
                    'choice_label' => 'libelle',

                ])
;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
