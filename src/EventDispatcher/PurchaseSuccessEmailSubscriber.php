<?php

namespace App\EventDispatcher;

use App\Entity\User;
use App\Event\PurchaseSuccessEvent;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\Security;

class PurchaseSuccessEmailSubscriber implements EventSubscriberInterface
{

    protected $logger;

    protected $mailer;

    protected $security;

    public function __construct(LoggerInterface $logger, MailerInterface $mailer, Security $security)
    {
        $this->logger = $logger;
        $this->mailer = $mailer;
        $this->security = $security;

    }

    public static function getSubscribedEvents()
    {
        // TODO: Implement getSubscribedEvents() method.
        return [
            'purchase.success' => 'sendSuccessEmail'
        ];
    }

    public function sendSuccessEmail(PurchaseSuccessEvent $purchaseSuccessEvent)
    {
        // Récupérer l'utilisateur actuellement en ligne

        $currentUser = $this->security->getUser();

        // Récupérer la commande (Se trouve dans PurchaseSuccessEvent)
        $purchase = $purchaseSuccessEvent->getPurchase();

        // Ecrire le mail
        $email = new TemplatedEmail();


        $email->to(new Address($currentUser->getEmail(), $currentUser->getUsername()))
            ->from("alliance-manga@hotmail.com")
            ->subject("Merci pour votre commande")
            ->htmlTemplate('emails/purchase_success.html.twig')
            ->context([
                'purchase' => $purchase,
                'user' => $currentUser
            ]);

        // Envoyer l'email

        $this->mailer->send($email);

        $this->logger->info("Email envoyé pour la commande n°" .
            $purchaseSuccessEvent->getPurchase()->getId());
    }
}