<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class SignUp
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(['min' => 3, 'max' => 50])]
        public string $name = '',
        #[Assert\Email(['message' => 'Enter a valid email address.'])]
        public string $email = '',
    ) {
    }
}
