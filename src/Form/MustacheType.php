<?php

namespace App\Form;

use App\Entity\Mustache;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MustacheType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', TextType::class, ['label' => 'Nom', 'attr' => ['placeholder' => 'Nom']])
                ->add('function', TextareaType::class, ['label' => 'Fonction', 'attr' => ['placeholder' => 'Fonction']])

        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Mustache::class,
        ]);
    }

}
