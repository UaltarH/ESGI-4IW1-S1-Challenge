<?php

namespace App\Entity;

enum PaymentMethod: string
{
    case paypal = 'PAYPAL';
    case stripe = 'STRIPE';
    case bank_transfer = 'BANK_TRANSFER';
    case credit_card = 'CREDIT_CARD';
    case other = 'OTHER';

}