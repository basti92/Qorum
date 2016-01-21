<?php
/**
 * Created by PhpStorm.
 * User: sebas
 * Date: 1/2/2016
 * Time: 10:04 PM
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

class TopicController extends Controller
{
    /**
     * @Route("/Topic/start", name="startTopic")
     */
    public function newAction(Request $request)
    {
        $tags = $this->getDoctrine()
            ->getRepository('AppBundle:Tag')->findAll();

        dump($tags);

        $topic = new Topic();


        $topic->setDate(new \DateTime('now'));
        $topic->setLastModified(new \DateTime('now'));



        $form = $this->createFormBuilder($topic)

            ->add('headline', TextType::class)
            ->add('description', TextareaType::class)
            ->add('tags', EntityType::class, array(
                'class' => 'AppBundle:Tag',
                'choice_label' => 'title',
                'choices' => $tags,
                "multiple" => true,
                'choices_as_values' => true,
                'expanded' => true,
            ))
            ->add('save', SubmitType::class, array('label' => 'Start new Topic'))
            ->getForm();


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database
            dump($form);
            $securityContext = $this->container->get('security.authorization_checker');
            $token = $this->get('security.token_storage')->getToken();
            /* @var $user User */
            $user = $token->getUser();
            dump($user);
            $topic->setAuthor($user);
            $topic->addActiveUser($user);
            dump($topic);
            $em = $this->getDoctrine()->getManager();
            $em->persist($topic);
            $em->flush();
            return $this->redirect($this->generateUrl('watchTopic', array('id' => $topic->getId())));
        }

        return $this->render('Topic/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
     * @Route("/Topic/{id}", name="watchTopic")
     */
    public function watchAction(Request $request, $id) {
        $topic = $this->getDoctrine()
            ->getRepository('AppBundle:Topic')->find($id);

        dump($topic);

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
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            return $this->render('Topic/watch.html.twig', array(
                'topic' => $topic,
                'form' => $form->createView(),
                'loggedIn' => $loggedIn
            ));

        }
        return $this->render('Topic/watch.html.twig', array(
            'topic' => $topic,
            'form' => $form->createView(),
            'loggedIn' => $loggedIn
        ));

    }


}