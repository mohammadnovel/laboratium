<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class MutuIndicatorForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', ['attr' => ['class' => 'form-control']])
            ->add('timed', 'text', ['attr' => ['class' => 'form-control']])
            ->add('submit', 'submit', ['label' => 'Submit', 'attr' => ['class' => 'btn btn-success']]);
    }
}
