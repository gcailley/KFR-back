<?php

namespace App\Form\Type\Association;

use App\Form\Type\AbstractRtlqType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RtlqPhotoDirectoryType extends AbstractRtlqType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('nom', TextType::class)
                ->add('actif', CheckboxType::class);
    }

    public function getName()
    {
        return 'PhotoDirectory';
    }
}
