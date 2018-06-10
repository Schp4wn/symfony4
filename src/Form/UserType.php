<?php
namespace App\Form;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class UserType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add("username",
                TextType::class,
                [
                    'attr'=>["placeholder"=>"Enter Name"],
                    'required'=>true
                ]
            )
            ->add("email",
                EmailType::class,
                [
                    'attr'=>["placeholder"=>"Enter Email"],
                    'required'=>true
                ]
            )
            ->add("password",
                PasswordType::class,
                [
                    'attr'=>["placeholder"=>"Password"],
                    'required'=>true
                ]
            )
            ->add("isActive",
            CheckboxType::class,
                [
                    'attr'=>["placeholder"=>"Utilisateur actif ?"],
                    'required'=>true
                ]
            )
            ->add("role" ,
            TextType::class,
                [
                    'attr'=>["placeholder"=>"Enter a Role"],
                    'required'=>true
                ]
            
            
            );
    }
}