<?php

namespace App\Form;

use App\Entity\Actor;
use App\Entity\Program;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('actors', EntityType::class, [
            'class' => Actor::class,
            'choice_label' => 'firstname',
            'multiple' => true,
            'expanded' => true,
            'by_reference' => false,
        ])
            ->add('title', TextType::class)
            ->add('summary', TextType::class)
            ->add('poster', TextType::class)
            ->add('category',EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Program::class,
        ]);
    }
}
