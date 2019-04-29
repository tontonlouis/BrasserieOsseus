<?php

namespace App\Form;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    private $repo;

    public function __construct(ProductRepository $repo)
    {
        $this->repo = $repo;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
               'attr' => ['placeholder' => 'Entrer votre nom...']
            ])
            ->add('title',TextType::class)
            ->add('description', TextareaType::class, [
                'attr' => ['rows' => 8]
            ])
            ->add('price', IntegerType::class)
            ->add('quatity', IntegerType::class)
            ->add('style', TextType::class)
            ->add('color', ChoiceType::class,[
                'choices' => $this->getChoicesColor()
            ])
            ->add('degrees', IntegerType::class)
            ->add('picturesFiles', FileType::class,[
                'required' => false,
                'multiple' => true
            ])
            ->add('new', CheckboxType::class,[
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'translation_domain' => 'forms'
        ]);
    }

    public function getChoicesColor()
    {
        $output = [];

        foreach (Product::COLOR as $key => $value)
        {
            $output[$value] = $key;
        }

        return $output;
    }

}
