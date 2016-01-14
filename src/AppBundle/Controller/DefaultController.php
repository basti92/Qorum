<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $mytopics = array();

        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            $token = $this->get('security.token_storage')->getToken();

            /* @var $user User */
            $user = $token->getUser();


            $mytopics = $user->getTopicsInvolved();


        }


        //  All Tags ordered by ContentSize related
        $tagrepo = $this->getDoctrine()
            ->getRepository('AppBundle:Tag');
        $tags = $tagrepo->findAll();
//        uasort($tags, 'cmpTags');

        //  Return
        return $this->render('default/index.html.twig', array(
                'tags' => $tags,
                'mytopics' => $mytopics)
        );
    }





    function cmpTags(Tag $a, Tag $b) {
        if ($a->SizeRelatedContext() == $b->SizeRelatedContent()) {
            return 0;
        }
        return ($a->SizeRelatedContent() < $b->SizeRelatedContent()) ? -1 : 1;
    }



}
