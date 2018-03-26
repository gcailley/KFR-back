<?php

namespace RoutanglangquanBundle\Form\Type\Association;

use RoutanglangquanBundle\Form\Type\AbstractRtlqType;
use RoutanglangquanBundle\Form\Type\Association\RtlqAdherentType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RtlqPhotoType extends AbstractRtlqType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('title', TextType::class)
                ->add('description', TextType::class)
                ->add('source', TextType::class)
                ->add('repertoire_id', NumberType::class);
    }

    public function getName()
    {
        return 'Photo';
    }
}
