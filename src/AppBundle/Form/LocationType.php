<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class LocationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::Class)
            ->add('status', HiddenType::Class, array('empty_data'=>'1'))
            ->add('dateIns', HiddenType::Class, array('data'=>'nowdate'))
            ->add('description', TextareaType::Class)            
            ->add('category', ChoiceType::Class, array( 'choices'=> array(
                                                'Beach'=>'beach',
                                                'Mountain'=>'Mountain',
                                                'Town'=>'town',
                                                'Natural Reserve'=>'natural_reserve')))
            ->add('imageFile', FileType::Class, array('required'=>false))
            ->add('imageName', HiddenType::Class, array('empty_data'=>null));
            
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Location'
        ));
    }
}
