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
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use App\Form\Type\AbstractRtlqType;
use App\Form\Type\Materiel\RtlqQuantiteVenteMaterielType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\Dto\Materiel\RtlqVenteMaterielDTO;

class RtlqVenteMaterielType extends AbstractRtlqType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add ( 'adherent_id', NumberType::class )
        ->add ( 'materiels', CollectionType::class, array(
            'entry_type' => RtlqQuantiteVenteMaterielType::class,
            'allow_add' => true,
            'allow_delete' => true,
            'prototype' => true,
            'by_reference' => false))
        ->add ( 'date_vente', DateType::class, $this->getDateFormatTZ())
        ->add ( 'prix_association', CheckBoxType::class )
        ->add ( 'cheque', CheckBoxType::class )
        ->add ( 'numero_cheque', TextType::class )
        ->add ( 'montant_total', NumberType::class );
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => RtlqVenteMaterielDTO::class,
        ));
    }

    public function getName()
    {
        return 'VenteMateriel';
    }
}
