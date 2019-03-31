<?php

namespace App\Form\Type\Association;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\Form\Type\AbstractRtlqType;

class RtlqEventType extends AbstractRtlqType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add ( 'description', TextType::class )
            ->add ( 'commentaire', TextType::class )
            ->add ( 'adresse', TextType::class )
            ->add ( 'date_creation', DateType::class, $this->getDateFormatTZ())
            ->add ( 'saison_id', TextType::class )
            ->add ( 'saison_name', TextType::class );
    }
    public function getName()
    {
        return 'Event';
    }
}
