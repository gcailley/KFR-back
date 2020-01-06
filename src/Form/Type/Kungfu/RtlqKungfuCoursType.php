<?php

namespace App\Form\Type\Kungfu;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use App\Form\Type\AbstractRtlqType;

class RtlqKungfuCoursType extends AbstractRtlqType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add ( 'description', TextType::class )
        ->add ( 'date_creation', DateType::class, $this->getDateFormatTZ())
        ->add ( 'thematique_tao', CheckBoxType::class )
        ->add ( 'thematique_application', CheckBoxType::class )
        ->add ( 'thematique_combat', CheckBoxType::class )
        ->add ( 'saison_id', NumberType::class )
        ->add ( 'saison_name', TextType::class )
        ->add ( 'nb_cours_essais', NumberType::class );
        
    }
    
    public function getName()
    {
        return 'kungfu-cours';
    }
}
