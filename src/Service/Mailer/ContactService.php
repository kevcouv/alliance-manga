<?php

namespace App\Service\Mailer;

use App\Entity\Contact;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Twig\Environment; // Mail en Html -> Twig

class ContactService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMail(Contact $contact)
    {
        $email = new TemplatedEmail();


        $email->from($contact->getEmail())
            ->to('kevcouv@hotmail.com')
            ->subject($contact->getSubject())
            ->htmlTemplate('emails/mailContact.html.twig')
        ->context(['contact' => $contact]);

        $this->mailer->send($email);
    }
}