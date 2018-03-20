<?php

namespace AppBundle\Admin;


use AppBundle\Entity\Tag;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProyectoAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('nombre', TextType::class)
            ->add('img', TextType::class)
            ->add('iframe', TextType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('nombre');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('nombre')
            ->add('created_at');
    }
}