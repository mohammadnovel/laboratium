<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class GeneralForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('description', 'textarea', ['label' => 'Description', 'attr' => ['placeholder' => 'Description', 'rows'=>10, 'class' => 'textarea-edit']])
            ->add('is_active', 'choice', [
                'choices' => $this->getStatus(),
                'label' => 'Activation',
                'empty_value' => 'Choose Activation',
                'attr' => ['class' => 'form-control select2']
            ])
            ->add('submit', 'submit', ['label' => 'Submit', 'attr' => ['class' => 'btn btn-success']]);
    }

    public function getStatus()
    {
        return config('status.activation');
    }
}
