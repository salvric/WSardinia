<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', TextType::Class, array('label' => false, 'attr'=>array('placeholder'=>'Email')))
                ->add('username', TextType::Class, array('label' => false, 'attr'=>array('placeholder'=>'Username')))
                ->add('plainPassword', RepeatedType::Class, 
                    array('type'=>PasswordType::Class,
                          'first_options' => array('label' => false, 'attr'=>array('placeholder'=>'Password')),
                          'second_options' => array('label' => false, 'attr'=>array('placeholder'=>'Repeat password')),
                          'invalid_message' => 'fos_user.password.mismatch'))
                ->add('name', TextType::Class, array('label' => false, 'attr'=>array('placeholder'=>'Name')))
                ->add('surname', TextType::Class, array('label' => false, 'attr'=>array('placeholder'=>'Surname')))
                ->add('city', TextType::Class, array('label' => false, 'attr'=>array('placeholder'=>'City')))
                ->add('country', CountryType::Class, array('placeholder' => 'Choose your country', 'label' => false))
                ->add('aboutMe', TextareaType::Class, array('label' => false, 'attr'=>array('placeholder'=>'Tell something about yourself...')))
                ->add('creationTime', HiddenType::Class, array('data'=>'ciao'))
                ->add('imageFile', FileType::Class, array('required'=>false, 'label' => 'Upload a profile pictures'))
                ->add('imageName', HiddenType::Class, array('empty_data'=>null));
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }
}