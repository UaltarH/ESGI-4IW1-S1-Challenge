<?php

namespace App\Utilities;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailUtils
{
    private $mailer;
    private string $apiKey;
    private string $urlBrevo;
    private int $idTemplateInscription;
    private int $idTemplateQuote; //devis
    private int $idTemplateInvoice; //facture
    private int $idTemplateResetPassword; //réinitialisation de mot de passe

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
        $this->apiKey = $_ENV['API_KEY_BREVO'];
        $this->urlBrevo = 'https://api.brevo.com/v3/smtp/email';
        $this->idTemplateInscription = 1;
        $this->idTemplateQuote = 2;
        $this->idTemplateInvoice = 3;
        $this->idTemplateResetPassword = 4;
    }

    public function sendEmailWithPdf(string $subject, string $content, string $senderEmail, string $recipientEmail, $pdf, $nameFilePdf): void
    {
        $email = (new Email())
            ->from($senderEmail)
            ->to($recipientEmail)
            ->subject($subject)
            ->text('Sending emails is fun again!')
            ->html($content)
            ->attach($pdf, $nameFilePdf . '.pdf', 'application/pdf');

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
        string $recipientFullName,
        string $quoteDateFormatted,
        string $quoteCompany,
        string $base64Quote,
        string $quoteName,
        string $urlAcceptQuote,
        string $urlRefuseQuote
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
                "prenom" => $recipientFullName,
                "date" => $quoteDateFormatted,
                "entreprise" => $quoteCompany,
                "urlaccept" => $urlAcceptQuote,
                "urlrefuse" => $urlRefuseQuote,
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
        string $quoteName,
        string $urlPaidInvoice
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
                "url" => $urlPaidInvoice,
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

    public function sendEmailForResetPassword(
        string $senderName,
        string $senderEmail,
        string $recipientEmail,
        string $recipientFullName,
        string $urlForReset
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
            "templateId" => $this->idTemplateResetPassword,
            "params" => [
                "url" => $urlForReset,
                "fullname" => $recipientFullName,
            ],
            "subject" => "Réinitialisation de mot de passe",
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

    // test email
    // $emailUtils->sendEmailForInscriptionUsingBrevo(
    //     "admin",
    //     "admin@couillase.com",
    //     "mathieupannetrat5@gmail.com",
    //     "Mathieu Pannetrat",
    //     "https://www.google.com"
    // );

    // $base64 = base64_encode(file_get_contents('https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png'));

    // $emailUtils->sendEmailForQuoteUsingBrevo(
    //     "admin",
    //     "admin@couillase.com",
    //     "mathieupannetrat5@gmail.com",
    //     "Mathieu",
    //     "12/09/2024",
    //     "Company Name",
    //     $base64,
    //     "Facture_Pannetrat_12/09/2024.png",
    //     "https://www.google.com",
    //     "https://www.google.com",
    // );

    // $emailUtils->sendEmailForInvoiceUsingBrevo(
    //     "admin",
    //     "admin@couillase.com",
    //     "mathieupannetrat5@gmail.com",
    //     "Mathieu",
    //     "12/09/2024",
    //     "Company Name",
    //     $base64,
    //     "Facture_Pannetrat_12/09/2024.png"
    // );
    //
}
