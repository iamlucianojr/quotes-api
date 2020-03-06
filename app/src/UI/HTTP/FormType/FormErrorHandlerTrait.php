<?php

declare(strict_types=1);

namespace App\UI\HTTP\FormType;

use Symfony\Component\Form\FormInterface;

trait FormErrorHandlerTrait
{
    public function getErrors(FormInterface $form): array
    {
        $errors = [];
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $childForm) {
            if (($childForm instanceof FormInterface) && $childErrors = $this->getErrors($childForm)) {
                $errors[$childForm->getName()] = $childErrors;
            }
        }

        return $errors;
    }
}
