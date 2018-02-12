<?php


namespace App\Form;

use App\Entity\Rom;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RomType extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options)

{
$builder->add('name', TextType::class)
        ->add('description', TextType::class)
        ->add('year', IntegerType::class)
        ->add('rating', IntegerType::class)
        ->add('istested', CheckboxType::class)
        ->add('publisher', TextType::class)
        ->add('developer', TextType::class)
        ->add('save', SubmitType::class, array('label' => 'Add'));
}

public function configureOptions(OptionsResolver $resolver)
{
$resolver->setDefaults(array(
'data_class' => Rom::class,
));
}
}