<?php


namespace App\Form;

use App\Entity\System;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SystemType extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options)

{
$builder->add('name', TextType::class)
        ->add('description', TextType::class)
        ->add('year', IntegerType::class)
        ->add('publisher', TextType::class)
        ->add('developer', TextType::class)
        ->add('image', FileType::class,[
                'attr'=>["placeholder"=>"choose image"], 
                'required'=>true,
                'data_class'=>null])
        ->add('save', SubmitType::class, array('label' => 'Add'));
}

public function configureOptions(OptionsResolver $resolver)
{
$resolver->setDefaults(array(
'data_class' => System::class,
));
}
}