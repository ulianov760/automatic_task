<?php

namespace App\Enums;

enum Gender
{
case WOMAN;
case MALES;

    public function readableText(): string
{

    return match ($this) {
        Gender::WOMAN => 'ж',
        Gender::MALES => 'м',
    };
}

}
