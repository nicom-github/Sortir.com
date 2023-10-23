<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Ville;
use App\Entity\Sortie;
use Cassandra\Date;
use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Time;

class CreationSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('dateHeureDebut', DateTimeZone::EUROPE, [
                'html5' => true,
            ])
            ->add('duree', Time::class)
            ->add('dateLimiteInscription', Date::class)
            ->add('nbInscriptionsMax', ChoiceType::class, [
                'choices' => [
                    ' 1', '2','3','4', ]
                ])
            ->add('infosSortie', TextareaFormField::class)
            ->add('lieu', ChoiceType::class)
            ->add('campus' , ChoiceList::class)
            ->add('latitude')
            ->add('longitude')
            ->add('ville')
                 ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
