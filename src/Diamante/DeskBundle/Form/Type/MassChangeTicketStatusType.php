<?php
/*
 * Copyright (c) 2015 Eltrino LLC (http://eltrino.com)
 *
 * Licensed under the Open Software License (OSL 3.0).
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://opensource.org/licenses/osl-3.0.php
 *
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@eltrino.com so we can send you a copy immediately.
 */
namespace Diamante\DeskBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Diamante\DeskBundle\Form\DataTransformer\StatusTransformer;
use Diamante\DeskBundle\Api\Command\MassActionCommands\MassChangeStatusCommand;

class MassChangeTicketStatusType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $statusTransformer = new StatusTransformer();
        $statusOptions = $statusTransformer->getOptions();

        $builder->add(
            $builder->create(
                'status',
                ChoiceType::class,
                array(
                    'label' => 'diamante.desk.attributes.status',
                    'required' => true,
                    'attr' => array('style' => 'width:140px'),
                    'choices' => $statusOptions
                ))
                ->addModelTransformer($statusTransformer)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => MassChangeStatusCommand::class,
                'intention' => 'ticket_status',
                'cascade_validation' => true
            )
        );
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    public function getBlockPrefix()
    {
        return 'diamante_ticket_form_status_mass_change';
    }
}
