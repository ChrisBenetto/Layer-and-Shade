<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Figurine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FigurineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la figurine',
                'help' => 'Nom officiel de la figurine',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'help' => 'Vous pouvez décrire les choix de peintures ainsi que les techniques utilisées , vos difficultés et vos réussites ...',
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'label' => 'Categorie',
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => true,
            ])
            ->add('pictures', FileType::class, [
                'label' => 'Images',
                'multiple' => true,
                'mapped' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Figurine::class,
        ]);
    }
}
