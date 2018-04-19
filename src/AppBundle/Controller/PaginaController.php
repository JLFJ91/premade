<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Pagina;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Pagina controller.
 */
class PaginaController extends Controller
{
    /**
     * Página de contacto.
     *
     * @Route("contacto", name="paginas_contacto")
     * @Method("GET")
     */
    public function contactoAction(Request $request)
    {
        $form = $this->createForm('AppBundle\Form\ContactoType');

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $mailer = $this->get('mailer');
                $message = $mailer->createMessage()
                    ->setSubject($form->get('CONTACTO PREMADE')->getData())
                    ->setFrom('contacto@premade.com')
                    ->setTo('contacto@premade.com')
                    ->setBody(
                        $this->renderView(
                            'AppBundle:Mail:contact.html.twig',
                            array(
                                'ip' => $request->getClientIp(),
                                'nombre' => $form->get('nombre')->getData(),
                                'email' => $form->get('email')->getData(),
                                'mensaje' => $form->get('mensaje')->getData()
                            )
                        )
                    );

                $mailer->send($message);

                $request->getSession()->getFlashBag()->add('success', 'Tu email ha sido enviado. Gracias');

                return $this->redirect($this->generateUrl('paginas_contacto'));
            }
        }

        return $this->render('pagina/contacto.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Lists all pagina entities.
     *
     * @Route("admin/paginas/", name="admin_paginas_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $paginas = $em->getRepository('AppBundle:Pagina')->findAll();

        return $this->render('pagina/admin_index.html.twig', array(
            'paginas' => $paginas,
        ));
    }

    /**
     * Creates a new pagina entity.
     *
     * @Route("admin/paginas/new", name="paginas_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $pagina = new Pagina();
        $form = $this->createForm('AppBundle\Form\PaginaType', $pagina);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pagina);
            $em->flush();

            return $this->redirectToRoute('paginas_show', array('id' => $pagina->getId()));
        }

        return $this->render('pagina/new.html.twig', array(
            'pagina' => $pagina,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a pagina entity.
     *
     * @Route("admin/paginas/{id}", name="paginas_show")
     * @Method("GET")
     */
    public function showAction(Pagina $pagina)
    {
        $deleteForm = $this->createDeleteForm($pagina);

        return $this->render('pagina/show.html.twig', array(
            'pagina' => $pagina,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pagina entity.
     *
     * @Route("admin/paginas/{id}/edit", name="paginas_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Pagina $pagina)
    {
        $deleteForm = $this->createDeleteForm($pagina);
        $editForm = $this->createForm('AppBundle\Form\PaginaType', $pagina);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('paginas_edit', array('id' => $pagina->getId()));
        }

        return $this->render('pagina/edit.html.twig', array(
            'pagina' => $pagina,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pagina entity.
     *
     * @Route("admin/paginas/{id}", name="paginas_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Pagina $pagina)
    {
        $form = $this->createDeleteForm($pagina);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pagina);
            $em->flush();
        }

        return $this->redirectToRoute('admin_paginas_index');
    }

    /**
     * Creates a form to delete a pagina entity.
     *
     * @param Pagina $pagina The pagina entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pagina $pagina)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('paginas_delete', array('id' => $pagina->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
