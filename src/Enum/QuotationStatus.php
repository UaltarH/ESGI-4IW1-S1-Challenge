<?php

namespace App\Enum;

enum QuotationStatus: string
{
    case pending = 'PENDING';
    case accepted = 'ACCEPTED';
    case refused = 'REFUSED';
    case paid = 'PAID';
}
