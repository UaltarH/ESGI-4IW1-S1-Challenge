<?php
// src/Service/EmailService.php

namespace App\Service;

use SebastianBergmann\Environment\Console;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService
{
    private $mailer;
    private string $apiKey;
    private string $urlBrevo;
    private int $idTemplateInscription;
    private int $idTemplateQuote; //devis
    private int $idTemplateInvoice; //facture

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
        $this->apiKey = $_ENV['API_KEY_BREVO'];
        $this->urlBrevo = 'https://api.brevo.com/v3/smtp/email';
        $this->idTemplateInscription = 1;
        $this->idTemplateQuote = 2;
        $this->idTemplateInvoice = 3;
    }

    public function sendEmailUsingMailer(string $subject, string $content, string $senderEmail, string $recipientEmail): void
    {
        $email = (new Email())
            ->from($senderEmail)
            ->to($recipientEmail)
            ->subject($subject)
            ->text('Sending emails is fun again!')
            ->html($content);

        try {
            $this->mailer->send($email);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function sendEmailForInscriptionUsingBrevo(
        string $senderName,
        string $senderEmail,
        string $recipientEmail,
        string $recipientFullName,
        string $urlForConfirmation
    ): void {
        $data = [
            "sender" => [
                "name" => $senderName,
                "email" => $senderEmail,
            ],
            "to" => [
                [
                    "email" => $recipientEmail,
                ]
            ],
            "templateId" => $this->idTemplateInscription,
            "params" => [
                "fullname" => $recipientFullName,
                "url" => $urlForConfirmation,
            ],
            "subject" => "Confirmation d'inscription",
        ];

        $headers = [
            'Accept: application/json',
            'api-key: ' . $this->apiKey,
            'Content-Type: application/json',
        ];

        $this->sendEmailUsingBrevo($data, $headers);
    }

    public function sendEmailForQuoteUsingBrevo(
        string $senderName,
        string $senderEmail,
        string $recipientEmail,
        string $recipientFirstName,
        string $quoteDateFormatted,
        string $quoteCompany,
        string $base64Quote,
        string $quoteName
    ): void {
        $data = [
            "sender" => [
                "name" => $senderName,
                "email" => $senderEmail,
            ],
            "to" => [
                [
                    "email" => $recipientEmail,
                ]
            ],
            "templateId" => $this->idTemplateQuote,
            "params" => [
                "prenom" => $recipientFirstName,
                "date" => $quoteDateFormatted,
                "entreprise" => $quoteCompany,
            ],
            "subject" => "Votre devis en pièce jointe",
            "attachment" => [["content" => $base64Quote, "name" => $quoteName]],
        ];

        $headers = [
            'Accept: application/json',
            'api-key: ' . $this->apiKey,
            'Content-Type: application/json',
        ];
        $this->sendEmailUsingBrevo($data, $headers);
    }

    public function sendEmailForInvoiceUsingBrevo(
        string $senderName,
        string $senderEmail,
        string $recipientEmail,
        string $recipientFirstName,
        string $quoteDateFormatted,
        string $quoteCompany,
        string $base64Quote,
        string $quoteName
    ): void {
        $data = [
            "sender" => [
                "name" => $senderName,
                "email" => $senderEmail,
            ],
            "to" => [
                [
                    "email" => $recipientEmail,
                ]
            ],
            "templateId" => $this->idTemplateInvoice,
            "params" => [
                "prenom" => $recipientFirstName,
                "date" => $quoteDateFormatted,
                "entreprise" => $quoteCompany,
            ],
            "subject" => "Votre facture en pièce jointe",
            "attachment" => [["content" => $base64Quote, "name" => $quoteName]],
        ];

        $headers = [
            'Accept: application/json',
            'api-key: ' . $this->apiKey,
            'Content-Type: application/json',
        ];

        $this->sendEmailUsingBrevo($data, $headers);
    }

    private function sendEmailUsingBrevo($data, $headers)
    {
        $ch = curl_init($this->urlBrevo);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        try {
            $d = curl_exec($ch);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        }

        curl_close($ch);
    }
}
