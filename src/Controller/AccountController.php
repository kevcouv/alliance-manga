<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\User;
use App\Form\AddressType;
use App\Form\RegistrationType;
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
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('account/index.html.twig');
    }


    /**
     * @Route("/accountDetails-{id}", name="accountDetails")
     */
    public function accountDetails(Request $request, User $user, $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $form = $this->createForm(UpdateAccountType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->setUpdatedAt(new \DateTime('now'));
            $em->persist($user);
            $em->flush();
            $this->addFlash(
                'success',
                'Vos informations ont bien été modifié'
            );
            return $this->redirectToRoute('accountDetails', ['id' => $id]);
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
            $this->addFlash('success', 'Votre mot de passe a bien été changer !');

            return $this->redirectToRoute('account');
        }
        return $this->render('account/resetPassword.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }

    /**
     * @Route("/address-{id}", name="address")
     */
    public function address($id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $address = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id)
            ->getAddresses();

        return $this->render('account/adresse.html.twig', [
            'address' => $address,
        ]);
    }


    /**
     * @Route("/newAddress-{id}", name="newAddress")
     */
    public function newAddress(Request $request, $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $address = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        // Ajout adresse

        $addAddress = new Address();

        $form = $this->createForm(AddressType::class, $addAddress);
        $form->handleRequest($request);
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->addAddress($addAddress);
            $addAddress->setUser($this->getUser());
            $em->persist($addAddress);
            $em->flush();

            $this->addFlash(
                'success',
                'Votre adresse a bien été ajouter'
            );
            return $this->redirectToRoute('address', ['id' => $id]);
        }


        return $this->render('account/addAddress.html.twig', [
            'form' => $form->createView(),
            'address' => $address,
        ]);
    }

    // Modifier adresse

    /**
     * @Route("/updateAddress-{id}", name="updateAddress")
     */
    public function UpdateAddress(Request $request, Address $address) : Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');


        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();;
            $em->flush();
            $this->addFlash(
                'success',
                'Votre adresse a été modifier'
            );
            return $this->redirectToRoute('account');
        }
        return $this->render('account/updateAddress.html.twig', [
            'address' => $address,
            'form' => $form->createView()
        ]);
    }

    //supprimer adresse

    /**
     * @Route("/deleteAddress-{id}", name="deleteAddress")
     */
    public function deleteAddress($id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');


        $em = $this->getDoctrine()->getManager();
        $address = $this->getDoctrine()
            ->getRepository(Address::class)
            ->find($id);
        $em->remove($address);
        $em->flush();

        $this->addFlash(
            'success',
            'Votre adresse a bien été supprimer!'
        );
        return $this->redirectToRoute('account');
    }


}
