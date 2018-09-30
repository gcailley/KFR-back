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
use App\Form\Dto\Materiel\RtlqQuantiteVenteMaterielDTO;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RtlqQuantiteVenteMaterielType extends AbstractRtlqType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add ( 'id', NumberType::class )
        ->add ( 'nom', TextType::class )
        ->add ( 'nombre', NumberType::class );
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => RtlqQuantiteVenteMaterielDTO::class,
        ));
    }


    public function getName()
    {
        return 'QuantiteVenteMateriel';
    }
}
