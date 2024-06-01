<?php

namespace App\Form;

use App\Entity\Recette;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Produit;

class RecetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, ['label' => 'Nom de la recette'])
            ->add('description', TextareaType::class, ['label' => 'Description'])
            ->add('instructions', TextareaType::class, ['label' => 'Instructions'])
            ->add('tempsPreparation', IntegerType::class, ['label' => 'Temps de préparation (minutes)'])
            ->add('tempsCuisson', IntegerType::class, ['label' => 'Temps de cuisson (minutes)'])
            ->add('imageFile', FileType::class, ['label' => 'Image', 'mapped' => false, 'required' => false])
            ->add('produits', EntityType::class, [
                'class' => Produit::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Épices et Herbes'
            ])
            ->add('save', SubmitType::class, ['label' => 'Soumettre la recette']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recette::class,
        ]);
    }
}
