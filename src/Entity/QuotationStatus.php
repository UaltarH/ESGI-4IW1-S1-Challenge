<?php

namespace App\Entity;

enum QuotationStatus: string
{
    case draft = 'DRAFT';
    case pending = 'PENDING';
    case accepted = 'ACCEPTED';
    case refused = 'REFUSED';
    case paid = 'PAID';
    case canceled = 'CANCELED';

}