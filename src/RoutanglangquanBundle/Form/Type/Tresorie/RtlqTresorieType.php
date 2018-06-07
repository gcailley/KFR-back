<?php

namespace RoutanglangquanBundle\Form\Type\Tresorie;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use RoutanglangquanBundle\Form\Type\AbstractRtlqType;


class RtlqTresorieType extends AbstractRtlqType {
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
			->add ( 'description', TextType::class )
			->add ( 'responsable', TextType::class )
			->add ( 'adherent_name', TextType::class )
			->add ( 'montant', MoneyType::class )
			->add ( 'numero_cheque', TextType::class )
			->add ( 'numero_remise_cheque', TextType::class )
			->add ( 'cheque', CheckboxType::class )
			->add ( 'etat_id', TextType::class )
			->add ( 'saison_id', TextType::class )
			->add ( 'categorie_id', TextType::class )
            ->add ( 'adherent_id', TextType::class )
			->add ( 'date_creation', DateType::class, $this->getDateFormat());
	}
	public function getName() {
		return 'tresorie';
	}
}