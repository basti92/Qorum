<?php
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TagController extends Controller {


    /**
     * @Route("/tag/{id}", name="watchTag")
     */
    public function watchAction(Request $request, $id){

        $tag = $this->getDoctrine()
            ->getRepository('AppBundle:Tag')->find($id);

        return $this->render('Tag/watch.html.twig', array(
                'tag' => $tag,
        ));
    }


}