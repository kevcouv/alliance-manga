<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ResetPasswordType;
use App\Entity\ChangePassword;
use App\Form\UpdateAccountType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="account")
     */
    public function index(): Response
    {
        return $this->render('account/index.html.twig');
    }


    /**
     * @Route("/accountDetails-{id}", name="accountDetails")
     */
    public function accountDetails(Request $request, User $user): Response
    {
        $form = $this->createForm(UpdateAccountType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $user->setUpdatedAt(new \DateTime('now'));
            $em->persist($user);
            $em->flush();
            $this->addFlash(
                'success',
                'Vos informations ont bien été modifié'
            );
            return $this->redirectToRoute('account');
        }
        return $this->render('account/details.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/passwordUpdate", name="passwordUpdate")
     */
    public function resetPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder)

    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $changePassword = new ChangePassword();
        $form = $this->createForm(ResetPasswordType::class, $changePassword);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $newpwd = $form->get('password')['first']->getData();
            // Si l'ancien mot de passe est bon
            $newEncodedPassword = $passwordEncoder->encodePassword($user, $newpwd);
            $user->setPassword($newEncodedPassword);

            $em->flush();
            $this->addFlash('success', 'Votre mot de passe a bien été changé !');

            return $this->redirectToRoute('home');
        }
        return $this->render('account/resetPassword.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }

}
