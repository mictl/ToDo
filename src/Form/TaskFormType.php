<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formular-Handling fürs Anlegen und Bearbeiten von Aufgaben (Task).
 */
class TaskFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titel',
            ])
            ->add('project',TextType::class, [
                'label' => 'Projekt',
            ])
            ->add('text',TextareaType::class, [
                'label' => 'Beschreibung',
            ])
            ->add('priority')
            ->add('status')
            ->add('parent', EntityType::class, [
               'class' => Task::class,
               'label' => 'Gibt es eine übergeordnete Aufgabe?',
                'help' => 'Optional. Ansonsten leer lassen.',
               'required' => false
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }


}