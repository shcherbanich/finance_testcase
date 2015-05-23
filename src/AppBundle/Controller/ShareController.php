<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Share;
use AppBundle\Form\ShareType;

/**
 * Share controller.
 *
 * @Route("/shares")
 */
class ShareController extends Controller
{

    /**
     * Lists all Share entities.
     *
     * @Route("/", name="shares")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Share')->findSharesByUser($this->getUser());

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Share entity.
     *
     * @Route("/", name="shares_create")
     * @Method("POST")
     * @Template("AppBundle:Share:new.html.twig")
     */
    public function createAction(Request $request)
    {

        $entity = new Share();

        $form = $this->createCreateForm($entity);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('AppBundle:Share')->findShareByName($form->getData()->getName(),$entity);

            $entity->removeUser($this->getUser());

            $entity->addUser($this->getUser());

            $em->persist($entity);

            $em->flush();

            return $this->redirect($this->generateUrl('shares_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Share entity.
     *
     * @param Share $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Share $entity)
    {
        $form = $this->createForm(new ShareType(), $entity, array(
            'action' => $this->generateUrl('shares_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Share entity.
     *
     * @Route("/new", name="shares_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Share();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Share entity.
     *
     * @Route("/{id}", name="shares_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Share')->findShareByUser($id, $this->getUser());

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Share entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Share entity.
     *
     * @Route("/{id}/edit", name="shares_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Share')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Share entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Share entity.
     *
     * @param Share $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Share $entity)
    {
        $form = $this->createForm(new ShareType(), $entity, array(
            'action' => $this->generateUrl('shares_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Share entity.
     *
     * @Route("/{id}", name="shares_update")
     * @Method("PUT")
     * @Template("AppBundle:Share:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Share')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Share entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('shares_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Share entity.
     *
     * @Route("/{id}", name="shares_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Share')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Share entity.');
            }

            $entity->removeUser($this->getUser());

            $em->flush();
        }

        return $this->redirect($this->generateUrl('shares'));
    }

    /**
     * Creates a form to delete a Share entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('shares_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Удалить из списка акций', 'attr' => ['class' => 'btn btn-danger']))
            ->getForm();
    }


}
