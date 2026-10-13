<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

final class WelcomeMailer
{
    public function __construct(private readonly MailerInterface $mailer)
    {
    }

    public function send(User $user): void
    {
        $this->mailer->send(
            (new TemplatedEmail())
                ->to($user->getUserIdentifier())
                ->subject('Welcome to Acme')
                ->htmlTemplate('email/welcome.html.twig'),
        );
    }
}
