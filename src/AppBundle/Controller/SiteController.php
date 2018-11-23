<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Articles;
use AppBundle\Entity\Commentaire;
use AppBundle\Form\PostType;
use AppBundle\Form\CommentaireType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SiteController extends Controller
{
    /**
     * @Route("/profil")
     */
    public function profilAction()
    {
       $user =  $this->container->get('security.token_storage')->getToken()->getUser();
        return $this->render('@App/Site/profil.html.twig', array('user' => $user));
    }

    /**
     * @Route("/accueil")
     */
    public function accueilAction()
    {
    $user = $this->container->get('security.token_storage')->getToken()->getUser();
    $posts =  $this->getDoctrine()->getManager()->getRepository('AppBundle:Articles')->findAll();
        $comms =  $this->getDoctrine()->getManager()->getRepository('AppBundle:Commentaire')->findAll();


        return $this->render('@App/Site/accueil.html.twig', array('user' =>$user, 'articles'=>$posts, 'comm'=>$comms));
    }

    /**
     * @Route ("/creerPost")
     */
    public function creerPostAction(Request $request)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $articles = new Articles();
        $form = $this->createForm(PostType::class,$articles);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $articles->setDate(new \DateTime());
            $articles->setUser($user);
            $articles->setCommentaire(null);
            $em = $this->getDoctrine()->getManager();
            $em->persist($articles);
            $em->flush();
            return $this->redirectToRoute('vosPost');

        }


        return $this->render('@App/Site/creerPost.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route ("/creerCommentaire")
     */
    public function creerCommentaireAction(Request $request)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $id = $request->query->get('id');
        $criteria1 = array('id'=>$id);
        $article = $this->getDoctrine()->getManager()->getRepository('AppBundle:Articles')->findOneBy($criteria1);

        $comm = new Commentaire();
        $form = $this->createForm(CommentaireType::class,$comm);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $comm->setUser($user);
            $comm->setArticle($article);
            $em = $this->getDoctrine()->getManager();
            $em->persist($comm);
            $em->flush();
            return $this->redirectToRoute('accueil');

        }


        return $this->render('@App/Site/creerCommentaire.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function voirCommentaireAction(Request $request){

        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $id = $request->query->get('id');
        $criteria1 = array('id'=>$id);
        $article = $this->getDoctrine()->getManager()->getRepository('AppBundle:Articles')->findOneBy($criteria1);

        $em = $this->getDoctrine()->getManager();
        $commentaires =  $em->getRepository('AppBundle:Commentaire')->getComm($id);

        return $this->render('@App/Site/voirCommentaire.html.twig', array('article'=>$article, 'comm'=>$commentaires));

    }

/**
 * @Route ("/vosPost")
 */

    public  function vosPostAction(Request $request){
        return $this ->render('@App/Site/vosPost.html.twig');
    }

}
