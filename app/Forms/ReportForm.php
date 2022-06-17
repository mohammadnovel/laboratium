<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class ReportForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('from_date', 'text', ['template' => 'layouts.form.date-picker', 'label' => 'From Date'])
            ->add('to_date', 'text', ['template' => 'layouts.form.date-picker', 'label' => 'To Date'])
            ->add('submit', 'submit', ['label' => 'Submit', 'attr' => ['class' => 'btn btn-success']]);
    }
}
