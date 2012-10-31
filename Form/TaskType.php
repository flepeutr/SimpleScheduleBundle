<?php

namespace IDCI\Bundle\SimpleScheduleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('day')
            ->add('starts_on', 'time')
            ->add('ends_on', 'time')
            ->add('activity')
            ->add('location')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'IDCI\Bundle\SimpleScheduleBundle\Entity\Task'
        ));
    }

    public function getName()
    {
        return 'idci_bundle_simpleschedulebundle_tasktype';
    }
}
