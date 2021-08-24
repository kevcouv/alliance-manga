<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    //S'enregistrer

    /**
     * @Route("/registration", name="registration")
     */
    public function registration(Request $request, UserPasswordEncoderInterface $encoder): Response
    {

        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()
                ->getManager();
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setIsDisabled(1);
            $user->setRole(['ROLE_USER']);
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                'Votre inscription vient d\'être valider'
            );

            return $this->redirectToRoute('home');
        }
        return $this->render('security/index.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    // Se connecter
    /**
     * @Route ("/login", name="login")
     */

    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $lastUsername = $utils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error !== null,
        ]);
    }

    // Se deconnecter
    /**
     * @Route ("/logout", name="logout")
     */

    public function logout()
    {

    }

}
