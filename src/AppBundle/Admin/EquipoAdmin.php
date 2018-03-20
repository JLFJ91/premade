<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 20/03/2018
 * Time: 12:08
 */

namespace AppBundle\Admin;


use AppBundle\Entity\Tag;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EquipoAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('nombre', TextType::class)
            ->add('apellidos', TextType::class)
            ->add('img', TextType::class)
            ->add('email', TextType::class)
            ->add('facebook', TextType::class)
            ->add('instagram', TextType::class)
            ->add('twitter', TextType::class)
            ->add('youtube', TextType::class)
            ->add('tags', EntityType::class, ['class' => Tag::class, 'choice_label' => 'tag']);
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('nombre');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('nombre')
            ->add('apellidos')
            ->add('email');
    }
}