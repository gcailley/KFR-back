<?php
namespace RoutanglangquanBundle\Form\Type\Security;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use RoutanglangquanBundle\Form\Type\AbstractRtlqType;

class RtlqCredentialsType extends AbstractRtlqType
    {
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
            $builder
                ->add('login')
                ->add('password');
        
        }
        public function getName()
        {
            return 'credentials';
        }
    
    }
