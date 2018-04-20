<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Proyecto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Proyecto controller.
 */
class ProyectoController extends Controller
{
    /**
     * Lists all proyecto entities.
     *
     * @Route("proyectos/", name="proyectos_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ultimoProyecto = $em->getRepository('AppBundle:Proyecto')->findBy([], ['createdAt' => 'DESC'], 1);
        $proyectos = $em->getRepository('AppBundle:Proyecto')->findBy([], ['createdAt' => 'DESC']);

        return $this->render('proyecto/index.html.twig', array(
            'ultimoProyecto' => $ultimoProyecto,
            'proyectos' => $proyectos,
        ));
    }
    
    /**
     * Lists all proyecto entities.
     *
     * @Route("admin/proyectos/", name="admin_proyectos_index")
     * @Method("GET")
     */
    public function adminIndexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $proyectos = $em->getRepository('AppBundle:Proyecto')->findAll();

        return $this->render('proyecto/admin_index.html.twig', array(
            'proyectos' => $proyectos,
        ));
    }

    /**
     * Creates a new proyecto entity.
     *
     * @Route("/new", name="proyectos_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $proyecto = new Proyecto();
        $form = $this->createForm('AppBundle\Form\ProyectoType', $proyecto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($proyecto);
            $em->flush();

            return $this->redirectToRoute('proyectos_show', array('id' => $proyecto->getId()));
        }

        return $this->render('proyecto/new.html.twig', array(
            'proyecto' => $proyecto,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing proyecto entity.
     *
     * @Route("admin/proyectos/{id}/edit", name="proyectos_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Proyecto $proyecto)
    {
        $deleteForm = $this->createDeleteForm($proyecto);
        $editForm = $this->createForm('AppBundle\Form\ProyectoType', $proyecto);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('proyectos_edit', array('id' => $proyecto->getId()));
        }

        return $this->render('proyecto/edit.html.twig', array(
            'proyecto' => $proyecto,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a proyecto entity.
     *
     * @Route("admin/proyectos/{id}", name="proyectos_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Proyecto $proyecto)
    {
        $form = $this->createDeleteForm($proyecto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($proyecto);
            $em->flush();
        }

        return $this->redirectToRoute('admin_proyectos_index');
    }

    /**
     * Creates a form to delete a proyecto entity.
     *
     * @param Proyecto $proyecto The proyecto entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Proyecto $proyecto)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('proyectos_delete', array('id' => $proyecto->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
