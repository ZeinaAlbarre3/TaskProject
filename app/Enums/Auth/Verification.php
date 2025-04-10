<?php

namespace App\Enums\Auth;

use phpDocumentor\Reflection\Types\Integer;

enum Verification: int
{
    case VERIFY_CODE = 10;
    case TWO_FA = 15;
    case RESET_PASSWORD = 20;
}
