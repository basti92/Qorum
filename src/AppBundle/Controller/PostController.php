<?php
/**
 * Created by IntelliJ IDEA.
 * User: maximilian
 * Date: 17.02.16
 * Time: 13:47
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Entity\Tag;
use AppBundle\Entity\Topic;
use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PostController extends Controller
{
    /**
     * @Route("/post/add/{id}", name="addPost")
     */

    public function addAction($id, Request $request) {

        $em = $this->getDoctrine()->getManager();
        $topic = $em->getRepository('AppBundle:Topic')->find($id);

        if (!$topic) {
            throw $this->createNotFoundException(
                'No Topic found for id ' . $id
            );
        }

        $post = new Post();
        $post->setDate(new \DateTime('now'));

        $loggedIn = false;

        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            $token = $this->get('security.token_storage')->getToken();

            /* @var $user User */
            $user = $token->getUser();
            $post->setAuthor($user);
            $post->setTopic($topic);
            $loggedIn = true;
        }
        $form = $this->createFormBuilder($post)
            ->add('content', TextareaType::class)
            ->add('save', SubmitType::class, array('label' => 'Reply'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($post);
            $em->flush();
            return $this->render('Topic/watch.html.twig', array(
                'topic' => $topic,
                'form' => $form->createView(),
                'loggedIn' => $loggedIn
            ));
        }
        return $this->render('Post/add.html.twig', array(
            'topic' => $topic,
            'form' => $form->createView(),
            'loggedIn' => $loggedIn
        ));

    }


    /**
     * @Route("/post/edit/{id}", name="editPost")
     */

    public function editAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();

        $post = $this->getDoctrine()->getRepository('AppBundle:Post')->find($id);

        if (!$post) {
            throw $this->createNotFoundException(
                'No Post found for id ' . $id
            );
        }

        $topic = $post->getTopic();

        if (!$topic) {
            throw $this->createNotFoundException(
                'No Topic found related to that Post'
            );
        }

        $loggedIn = false;

        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            $token = $this->get('security.token_storage')->getToken();

            /* @var $user User */
            $user = $token->getUser();
            $post->setAuthor($user);
            $post->setTopic($topic);
            $loggedIn = true;
        }
        $form = $this->createFormBuilder($post)
            ->add('content', TextareaType::class)
            ->add('save', SubmitType::class, array('label' => 'Save Changes'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirect($this->generateUrl('watchTopic', array('id' => $topic->getId())));
        }
        return $this->render('Post/add.html.twig', array(
            'topic' => $topic,
            'form' => $form->createView(),
            'loggedIn' => $loggedIn
        ));

    }


    /**
     * @Route("/post/delete/{id}", name="deletePost")
     */

    public function delteAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();
        $post = $this->getDoctrine()->getRepository('AppBundle:Post')->find($id);

        if (!$post) {
            throw $this->createNotFoundException(
                'No Post found for id ' . $id
            );
        }
        $topicid = $post->getTopic()->getId();
        $em->remove($post);
        $em->flush();

        return $this->redirect($this->generateUrl('watchTopic', array('id' => $topicid)));
    }
}