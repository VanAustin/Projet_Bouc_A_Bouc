<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use FOS\UserBundle\Form\Type\ProfileFormType as BaseProfileFormType;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', FileType::class, array(
            'label' => 'Votre avatar',
            'required' => false,
        ));
        $builder->add('address', null, array(
            'label' => 'Votre adresse',
        ));
        $builder->add('lat', HiddenType::class, array(
            'attr' => array('data-geo' => 'lat'),
        ));
        $builder->add('lng', HiddenType::class, array(
            'attr' => array('data-geo' => 'lng'),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    public function getParent()
    {
        return BaseProfileFormType::class;
    }

    public function getBlockPrefix()
    {
        return 'app_user_profile';
    }
}
