<?php

namespace App\Form\Type\Association;

use App\Form\Type\AbstractRtlqType;
use App\Form\Type\Association\RtlqAdherentType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RtlqPhotoDirectoryType extends AbstractRtlqType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('nom', TextType::class);
    }

    public function getName()
    {
        return 'PhotoDirectory';
    }
}
