<?php

namespace App\Form;

use App\Entity\Gallery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class GalleryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class ,$this->getConfiguration('Titre', "Le titre de l'image"))
            ->add('caption', TextType::class, $this->getConfiguration('Légende', "La légende de 'limage"))
            ->add('imageFile', VichImageType::class,['label' => "L'image"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Gallery::class,
        ]);
    }

    protected function getConfiguration($label, $placeholder, $options = []): array
    {
        return array_merge([
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ], $options);
    }
}
