<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{

    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }


    //S'enregistrer

    /**
     * @Route("/registration", name="registration")
     * @throws \Exception
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
            $user->setToken($this->generateToken());
            $em->persist($user);
            $em->flush();

            $email = new TemplatedEmail();


            $email->from("alliance-manga@hotmail.com")
                ->to(new Address($user->getEmail(), $user->getToken()))
                ->subject("Merci pour votre inscription")
                ->htmlTemplate('emails/registration_success.html.twig')
                ->context([
                    'expiration_date' => new \DateTime('+7 days'),
                    'user' => $user
                ]);

            // Envoyer l'email

            $this->mailer->send($email);

            $this->addFlash(
                'success',
                'Votre inscription a bien été enregistrée. Un mail de confirmation vous a été envoyé'
            );

            return $this->redirectToRoute('home');
        }
        return $this->render('security/index.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/confirm-account-{id}", name="confirm_account")
     */
    public function confirmAccount($id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);

        if ($user)
        {
            $user->setToken(null);
            $user->setIsDisabled(false);
            $em = $this->getDoctrine()
                ->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash(
                'success',
                'Votre inscription est validée. Bienvenue chez Alliance Manga!'
            );
            return $this->redirectToRoute("home");
        } else {
            $this->addFlash(
                'warning',
                'Le compte n\'existe pas!'
            );
            return $this->redirectToRoute('home');

        }
    }


    /**
     * @return string
     * @throws \Exception
     */
    public function generateToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }



    // Se connecter (VIA POPUP)
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
