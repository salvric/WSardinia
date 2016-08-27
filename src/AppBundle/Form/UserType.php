<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Vich\UploaderBundle\Form\Type\VichImageType;


class UserType extends AbstractType{

	public function buildForm(FormBuilderInterface $builder, array $options){

		$builder->add('name', TextType::Class)
                ->add('surname', TextType::Class)
                ->add('username', TextType::Class)
                ->add('email', TextType::Class)
                ->add('city', TextType::Class)
                ->add('country', CountryType::Class)
                ->add('creationTime', HiddenType::Class, array('data'=>'ciao'))
                ->add('imageFile', FileType::Class, array('required'=>false))
                ->add('imageName', HiddenType::Class, array('empty_data'=>null));
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver){

		$resolver->setDefaults( array('data_class' => 'AppBundle\Entity\User') ); 
	}

	public function getName() {

		return 'appBundle_user';
	}
}