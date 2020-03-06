<?php

declare(strict_types=1);

namespace App\UI\HTTP\FormType;

use App\UI\HTTP\Dto\ShoutRequestDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

final class ShoutRequestTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('author', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new NotNull(),
                ],
            ])
            ->add('limit', IntegerType::class, [
                'empty_data' => '1',
                'constraints' => [
                    new GreaterThan(0),
                    new LessThanOrEqual(10),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ShoutRequestDto::class,
            'csrf_protection' => false,
        ]);
    }
}
