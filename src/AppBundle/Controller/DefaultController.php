<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('shares'));
    }

    /**
     * Creates a new User entity.
     *
     * @Route("/registration", name="user_create")
     * @Method("POST")
     * @Template("AppBundle:Default:registration.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new User();
        $form = $this->registrationForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $roleUser = $em->getRepository('AppBundle:Role')->getRoleByName(\AppBundle\Repository\RoleRepository::ROLE_USER);

            $entity->getUserRoles()->add($roleUser);

            $em->persist($entity);

            $em->flush();

            return $this->redirect($this->generateUrl('_security_login'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }


    /**
     * Creates a form to create a User entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function registrationForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('user_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Регистрация', 'attr' =>['class' => 'btn btn-success']));

        return $form;
    }


    /**
     * Displays a form to create a new User entity.
     *
     * @Route("/registration", name="registration")
     * @Method("GET")
     * @Template()
     */
    public function registrationAction()
    {
        $entity = new User();
        $form   = $this->registrationForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
}
