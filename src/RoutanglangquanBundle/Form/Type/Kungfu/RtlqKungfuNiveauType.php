<?php

namespace RoutanglangquanBundle\Form\Type\Kungfu;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use RoutanglangquanBundle\Form\Type\AbstractRtlqEnumType;

class RtlqKungfuNiveauType extends AbstractRtlqEnumType {
	public function getName() {
		return 'kungfu_kungfuniveau';
	}
}