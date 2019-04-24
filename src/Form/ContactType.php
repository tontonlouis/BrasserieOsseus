<?php

namespace App\Form;

use App\Entity\Contact;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'attr' => ['placeholder' => ' Entrer votre nom...']
            ])
            ->add('lastname', TextType::class, [
                'attr' => ['placeholder' => ' Entrer votre prénom...']
            ])
            ->add('email', EmailType::class, [
                'attr' => ['placeholder' => ' Entrer votre email...']
            ])
            ->add('phone', TelType::class, [
                'attr' => ['placeholder' => ' Entrer votre numéro de téléphone...']
            ])
            ->add('message', TextareaType::class, [
                'attr' => [
                    'placeholder' => ' Entrer votre message...',
                    'rows' => 8
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
            'translation_domain' => 'contact',
        ]);
    }
}
