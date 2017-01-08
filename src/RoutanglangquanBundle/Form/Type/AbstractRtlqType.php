<?php

namespace RoutanglangquanBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

abstract class AbstractRtlqType extends AbstractType {
	public function getDateFormat() {
		return array (
				'widget' => 'single_text',
				'format' => 'yyyy-MM-dd' );
	}
}