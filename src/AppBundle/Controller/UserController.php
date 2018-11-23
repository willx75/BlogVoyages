<?php


namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;




class UserController extends Controller
{
    /**
     * @Route("/inscription")
     */
    public function inscriptionAction(Request $request)
    {
        //creation d'un nouvel utilisateur and creation du formulaire associée

        $user = new User();
        $form = $this->createForm(UserType::class, $user);


        $form->handleRequest($request);
        //$form = $this->createFormBuilder($user)
        // ->add('nom', TextType::class)
            //->add('prenom', TextType::class)
            //->add('email', TextType::class)
            //->add('mdp', TextType::class)
            //->add('send', SubmitType::class, array('label' => 'Inscription'))
            //->getForm();
        // On fait le lien Requête <-> Formulaire
        // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
        // On vérifie que les valeurs entrées sont correctes

        if ($form->isSubmitted() && $form->isValid()) {
            // on encode le mdp des nouveaux users
            $encoder = $this->get('security.password_encoder');
            $password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $user->setRole('ROLE_USER');

            // On l'enregistre notre objet $advert dans la base de données, par exemple
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('connexion');
        }
        // On redirige vers la page de visualisation de l'annonce nouvellement créée

        // return $this->redirect($this->generateUrl('merci', array('id' => $user->getId())));

        return $this->render('@App/User/inscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/connexion")
     */
    public function connexionAction()
    {
        return $this->render('@App/Security/connexion.html.twig', array(

        ));
    }

    /**
     * @Route("/merci")
     */
    public function merciAction()
    {
        return $this->render('@App/Security/merci.html.twig', array(

        ));
    }


}