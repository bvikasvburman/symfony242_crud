<?php

namespace Acme\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\BlogBundle\Entity\BlogComment;
use Acme\BlogBundle\Form\BlogCommentType;

/**
 * BlogComment controller.
 *
 * @Route("/blogcomment")
 */
class BlogCommentController extends Controller
{

    /**
     * Lists all BlogComment entities.
     *
     * @Route("/", name="blogcomment")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AcmeBlogBundle:BlogComment')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new BlogComment entity.
     *
     * @Route("/", name="blogcomment_create")
     * @Method("POST")
     * @Template("AcmeBlogBundle:BlogComment:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new BlogComment();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('blogcomment_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a BlogComment entity.
    *
    * @param BlogComment $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(BlogComment $entity)
    {
        $form = $this->createForm(new BlogCommentType(), $entity, array(
            'action' => $this->generateUrl('blogcomment_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new BlogComment entity.
     *
     * @Route("/new", name="blogcomment_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new BlogComment();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a BlogComment entity.
     *
     * @Route("/{id}", name="blogcomment_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeBlogBundle:BlogComment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BlogComment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing BlogComment entity.
     *
     * @Route("/{id}/edit", name="blogcomment_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeBlogBundle:BlogComment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BlogComment entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a BlogComment entity.
    *
    * @param BlogComment $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(BlogComment $entity)
    {
        $form = $this->createForm(new BlogCommentType(), $entity, array(
            'action' => $this->generateUrl('blogcomment_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing BlogComment entity.
     *
     * @Route("/{id}", name="blogcomment_update")
     * @Method("PUT")
     * @Template("AcmeBlogBundle:BlogComment:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeBlogBundle:BlogComment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BlogComment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('blogcomment_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a BlogComment entity.
     *
     * @Route("/{id}", name="blogcomment_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AcmeBlogBundle:BlogComment')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find BlogComment entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('blogcomment'));
    }

    /**
     * Creates a form to delete a BlogComment entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('blogcomment_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
