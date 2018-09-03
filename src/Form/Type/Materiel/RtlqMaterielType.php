<?php

namespace App\Form\Type\Materiel;

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
use App\Form\Type\AbstractRtlqType;

class RtlqMaterielType extends AbstractRtlqType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add ( 'nom', TextType::class )
        ->add ( 'prix_achat', MoneyType::class )
        ->add ( 'prix_vente', MoneyType::class )
        ->add ( 'date_achat', DateType::class )
        ->add ( 'association', CheckBoxType::class )
        ->add ( 'stock', NumberType::class )
        ->add ( 'actif', CheckBoxType::class );
    }
    
    public function getName()
    {
        return 'Materiel';
    }
}
