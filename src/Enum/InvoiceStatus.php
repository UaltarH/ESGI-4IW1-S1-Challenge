<?php

namespace App\Enum;

enum InvoiceStatus: string
{
    case not_paid = 'NOT_PAID';
    case paid = 'PAID';
}
