<?php

namespace RoutanglangquanBundle\Form\Type\Kungfu;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use RoutanglangquanBundle\Form\Type\AbstractRtlqType;

class RtlqKungfuType extends AbstractRtlqType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add ( 'nom', TextType::class )
        ->add ( 'nom_chinois', TextType::class )
        ->add ( 'description', TextType::class )
        ->add ( 'arme', TextType::class )
        ->add ( 'arme_url', TextType::class )
        ->add ( 'video_url', TextType::class )
        ->add ( 'style_id', NumberType::class )
        ->add ( 'style_name', TextType::class )
        ->add ( 'niveau_id', NumberType::class )
        ->add ( 'niveau_name', TextType::class )
        ->add ( 'actif', BooleanType::class );
    }
    
    public function getName()
    {
        return 'kungfu-tao';
    }
}
