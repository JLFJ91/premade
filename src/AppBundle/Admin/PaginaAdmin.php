<?php

namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PaginaAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('titulo', TextType::class)
            ->add('contenido', TextType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('titulo');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('titulo');
    }
}