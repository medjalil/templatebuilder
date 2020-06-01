<?php

namespace App\Form;

use App\Entity\Attachment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class AttachmentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('joint', FileType::class, [
                    'label' => false,
                    'attr' => ['placeholder' => 'Choisir votre fichier'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Attachment::class,
        ]);
    }

}
