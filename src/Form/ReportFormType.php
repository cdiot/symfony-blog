<?php

namespace App\Form;

use App\Entity\Report;
use App\Entity\ReportCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReportFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Elle me permettra de te contacter si besoin.',
                    'class' => 'form-input'
                ],
                'constraints' => [
                    new Email([
                        'message' => 'Entre une adresse e-mail valide.',
                    ]),
                    new NotBlank([
                        'message' => 'Entre ton adresse e-mail ',
                    ]),
                ],
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie',
                'required' => true,
                'class' => ReportCategory::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-input'
                ],
                'multiple' => false,
                'expanded' => false
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Commentaire',
                'attr' => [
                    'placeholder' => 'Donne moi quelques informations sur le problème que tu rencontres.',
                    'class' => 'form-input'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entre ton commentaire.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Report::class
        ]);
    }
}
