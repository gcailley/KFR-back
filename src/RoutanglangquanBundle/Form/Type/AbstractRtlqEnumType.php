<?php

namespace RoutanglangquanBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use RoutanglangquanBundle\Form\Type\AbstractRtlqType;

abstract class AbstractRtlqEnumType extends AbstractRtlqType {
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add ( 'value', TextType::class );
	}
}