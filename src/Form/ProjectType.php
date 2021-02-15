<?php

namespace App\Form;

use App\Entity\Companies;
use App\Entity\Projects;
use App\Entity\Workers;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('start_date')
            ->add('name')
            ->add('price_sold')
            ->add('estimated_time')
            ->add('spent_time')
            ->add('technology')
            ->add('type')
            ->add('companies',EntityType::class,[
                'class' =>Companies::class,
                'choice_label'=>'name'])
            ->add('workers',EntityType::class,[
                'class' =>Workers::class,
                'expanded' =>true,
                'multiple' => true,
                'choice_label'=>'name'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projects::class,
        ]);
    }
}
