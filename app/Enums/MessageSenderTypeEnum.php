<?php

namespace App;

enum MessageSenderTypeEnum: string
{
    case USER = 'user';
    case PROVIDER = 'provider';
}
