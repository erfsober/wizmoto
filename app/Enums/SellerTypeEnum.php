<?php

namespace App\Enums;

enum SellerTypeEnum: string
{
    case PRIVATE = 'private';
    case DEALER = 'dealer';

    public function getLabel(): string
    {
        return match($this) {
            self::PRIVATE => 'Private Seller',
            self::DEALER => 'Dealer',
        };
    }

    public static function getOptions(): array
    {
        return [
            self::PRIVATE->value => self::PRIVATE->getLabel(),
            self::DEALER->value => self::DEALER->getLabel(),
        ];
    }
}
