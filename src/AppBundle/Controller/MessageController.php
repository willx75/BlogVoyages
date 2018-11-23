<?php

/**
 * Created by PhpStorm.
 * User: will2
 * Date: 19/04/2018
 * Time: 13:40
 */


namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Message;
use AppBundle\Form\UserType;
use AppBundle\Form\MessageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class MessageController extends Controller
{



    public function friendsAction(){
        $user =  $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->findAll();

        return $this->render('@App/Message/friends.html.twig',
            array('user'=>$user));
    }

    public function sentAction(){
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        return $this->render('@App/Message/sentmessage.html.twig',
            array('user'=>$user));
    }

    public function boiteDeReceptionAction(){
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $messages = $em->getRepository('AppBundle:Message')->getMessages($user->getId());
        return $this->render('@App/Message/boitedereception.html.twig',
            array('user'=>$user, 'messages'=>$messages));
    }


    /**
     * @Route("/send", name="register")
     */
    public function sendAction(Request $request)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $id = $request->query->get('id');
        $criteria1 = array('id'=>$id);
        $receveur = $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->findOneBy($criteria1);

        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $message -> setEmetteur($user);
            $message -> setReceveur($receveur);
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
            return $this->redirectToRoute('sent');
        }

        return $this->render('@App/Message/message.html.twig', array(
            'form' => $form->createView(), 'receveur'=>$receveur
        ));
    }



}