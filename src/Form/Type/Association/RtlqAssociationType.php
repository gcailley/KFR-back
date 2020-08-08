<?php

namespace App\Form\Type\Association;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use App\Form\Type\AbstractRtlqType;

class RtlqAssociationType extends AbstractRtlqType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('date_creation', DateType::class, $this->getDateFormatTZ())
            ->add('active', CheckBoxType::class)
            ->add('siege_social', TextType::class)
            ->add('email', TextType::class)
            ->add('numero_siren', TextType::class)
            ->add('url_extranet', TextType::class)
            ->add('url_intranet', TextType::class)
            ->add('numero_compte_bancaire', TextType::class)
            ->add('closed', CheckBoxType::class)
            ->add('message', TextType::class);
    }
    public function getName()
    {
        return 'Association';
    }
}
