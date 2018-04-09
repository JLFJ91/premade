<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Pagina;

class MainController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $queHacemos = $em->getRepository('AppBundle:Pagina')->find(Pagina::$PAGINA_QUE_HACEMOS);
        return $this->render('main/index.html.twig', [
            'queHacemos' => $queHacemos,
        ]);
    }
}
