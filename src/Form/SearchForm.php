<?php

namespace App\Form;

use App\data\SearchData;
use App\Entity\Campus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('campus', EntityType::class, [
                'label'=>false,
                'class' => campus::class,
                'choice_label' => 'nom'
                ])

            ->add('sortieNom', TextType::class, [
                'required' => false,
                'label'=>false,

            ])

            ->add('dateDebut', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
                'label' => false,
                'mapped' => false,
            ])

            ->add('dateFin', DateType::class, [
                'widget' => 'single_text',
                'label' => false,
                'required' => false,
                'mapped' => false,

            ])

            ->add('isInscrit', CheckboxType::class, [
                'label'=>false,
                'required' => false,
            ])
            ->add('isNotInscrit', CheckboxType::class, [
                'label'=>false,
                'required' => false,
            ])
            ->add('isOrganisateur', CheckboxType::class, [
                'label'=>false,
                'required' => false,
            ])
            ->add('isSortiesFinie', CheckboxType::class, [
                'label'=>false,
                'required' => false,
            ])
        ;


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}