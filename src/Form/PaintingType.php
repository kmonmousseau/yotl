<?php

namespace App\Form;

use App\DTO\PaintingDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PaintingType
 * @author Kevin Monmousseau <k.monmousseau@gmail.com>
 */
final class PaintingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'trim' => true,
                'required' => true,
            ])
            ->add('date', DateType::class, [
                'years' => range((int)(new \DateTime)->format('Y'), 1995),
                'required' => true,
            ])
            ->add('image', FileType::class)
            ->add('width', IntegerType::class, [
                'trim' => true,
                'required' => true,
            ])
            ->add('height', IntegerType::class, [
                'trim' => true,
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PaintingDTO::class,
        ]);
    }
}
