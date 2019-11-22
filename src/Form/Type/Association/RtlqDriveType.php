<?php

namespace App\Form\Type\Association;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\Form\Type\AbstractRtlqType;

class RtlqDriveType extends AbstractRtlqType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add ( 'name', TextType::class )
            ->add ( 'filename', TextType::class )
            ->add ( 'type', TextType::class )
            ->add ( 'size', TextType::class )
            ->add ( 'source', TextType::class )
            ->add ( 'thumbnail', TextType::class );
    }
    public function getName()
    {
        return 'Drive';
    }
}
