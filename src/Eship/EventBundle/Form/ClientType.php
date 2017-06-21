<?php

namespace Eship\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('clientEmail')
                ->add('firstName')
                ->add('lastName')
                ->add('initial')
                ->add('age')
                ->add('gender')
                ->add('phone')
                ->add('password')
                ->add('relationshipWithUPRM')
                ->add('specification')
                ->add('department')
                ->add('businessNotCNDE')
                ->add('learnOfServices')
                ->add('address1')
                ->add('address2')
                ->add('city')
                ->add('zipCode')
                ->add('country');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Eship\EventBundle\Entity\Client'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'eship_eventbundle_client';
    }


}
