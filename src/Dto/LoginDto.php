<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;

final class LoginDto
{
    #[Email, NotNull, NotBlank]
    public $email;

    #[Type('string'), NotNull, NotBlank]
    public $password;
}