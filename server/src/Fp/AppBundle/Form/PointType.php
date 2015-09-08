<?php

namespace Fp\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of PointType.
 *
 * @author alex
 */
class PointType extends AbstractType
{
    /**
     * Build form
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'hidden')
            ->add('name', 'text')
            ->add('dueDate', 'date', ['widget' => 'single_text'])
            ->add('save', 'submit', ['label' => 'Create New point']);
    }

    /**
     * Set default options
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Fp\AppBundle\Document\Point',
            'intention' => 'pointform',
        ]);
    }

    /**
     * Returns form name
     *
     * @return string
     */
    public function getName()
    {
        return 'points';
    }
}
