<?php

declare(strict_types=1);

namespace App\FormType;

use Symfony\Component\Form\FormInterface;

interface FormErrorHandlerInterface
{
    public function getErrors(FormInterface $form): array;
}
