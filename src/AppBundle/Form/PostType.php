<?php
/**
 * Created by PhpStorm.
 * User: will2
 * Date: 27/04/2018
 * Time: 14:11
 */

namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lieu', TextType::class)
            ->add('nomArticle', TextType::class)
            ->add('contenu', TextType::class);
    }

    public function configureOption (OptionsResolver $resolver){
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Articles',
        ]);
    }
}