<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class RoleForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text')
            ->add('submit', 'submit', ['label'=>'Submit', 'attr'=>['class'=>'btn btn-success']]);
    }
}
