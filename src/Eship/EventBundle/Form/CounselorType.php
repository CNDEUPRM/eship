<?php

namespace Eship\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CounselorType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('counselorEmail')->add('firstName')->add('lastName')->add('initial')->add('age')->add('gender')->add('phone')->add('password')->add('position')->add('department')->add('cndeOrganization')->add('isActive')->add('isAdmin');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Eship\EventBundle\Entity\Counselor'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'eship_eventbundle_counselor';
    }


}
