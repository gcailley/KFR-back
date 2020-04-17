<?php

namespace App\Form\Type\Kungfu;

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

class RtlqKungfuAdherentTaoType extends AbstractRtlqType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nb_revision', NumberType::class)
            ->add('niveau', NumberType::class)
            ->add('drive_id', TextType::class)
            ->add('favoris', CheckBoxType::class)
            ->add('date_update', DateType::class, $this->getDateFormatTZ());
    }

    public function getName()
    {
        return 'kungfu-adherent-tao';
    }
}
