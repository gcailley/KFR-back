<?php

namespace RoutanglangquanBundle\Form\Type\Saison;

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

class RtlqSaisonType extends AbstractRtlqType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add ( 'nom', TextType::class )
            ->add ( 'active', CheckboxType::class )
            ->add ( 'date_debut', DateType::class, $this->getDateFormat())
            ->add ( 'date_fin', DateType::class, $this->getDateFormat());
    }
    public function getName()
    {
        return 'saison';
    }
}
