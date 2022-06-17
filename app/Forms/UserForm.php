<?php

namespace App\Forms;

use App\Models\Company;
use Kris\LaravelFormBuilder\Form;

class UserForm extends Form
{
    public function buildForm()
    {
        $this
            
            ->add('name', 'text', ['attr' => ['class' => 'form-control']])
            ->add('email', 'text', ['attr' => ['class' => 'form-control']])
            ->add('phone', 'text', ['attr' => ['class' => 'form-control']])
            ->add('address', 'text', ['attr' => ['class' => 'form-control']])
            ->add('password', 'text', ['attr' => ['class' => 'form-control']])
            ->add('type', 'choice', [
                'choices' => $this->getUserType(),
                'label' => 'User Type',
                'empty_value' => 'Choose User Type',
                'attr' => ['class' => 'form-control select2']
            ])
            ->add('submit', 'submit', ['label' => 'Submit', 'attr' => ['class' => 'btn btn-success']]);
    }

    public function getUserType()
    {
        return config('status.type');
    }

}
