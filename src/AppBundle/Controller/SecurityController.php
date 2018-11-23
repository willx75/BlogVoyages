<?php
/**
 * Created by PhpStorm.
 * User: will2
 * Date: 26/04/2018
 * Time: 22:29
 */

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;



class SecurityController extends Controller
{
    /**
     * @Route("/connexion", name="connexion")
     */
    public function connexionAction(Request $request)
    {
        $helper = $this->get('security.authentication_utils');

        return $this->render(
            '@App/Security/connexion.html.twig',
            array(
                'last_username' => $helper->getLastUsername(),
                'error'         => $helper->getLastAuthenticationError(),
            )
        );
    }
    /**
    $error = $authenticationUtils->getLastAuthenticationError();

    $error = $authenticationUtils->getLastAuthenticationError();

    $mail = $authenticationUtils -> getMail();


    return $this->render('@App/Security/connexion.html.twig', array(
    'mail' => $mail,
    'error'         => $error,
    ));
    }**/

    /**
     * @Route("/check_connexion, name="check_connexion")
     */
    public function checkConnexionAction()
    {
        return $this->render('AppBundle:Security:check_connexion.html.twig', array(
            // ...
        ));
    }


    /**
     * @Route("/Deconnexion" name = "deconnexion")
     */

    public function deconnexion(){
        return $this->render('AppBundle:Security:connexion.html.twig', array(
        ));
    }

}
