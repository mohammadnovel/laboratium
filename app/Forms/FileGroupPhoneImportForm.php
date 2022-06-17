<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class FileGroupPhoneImportForm extends Form
{
    public function buildForm()
    {
        $this->add('file', 'file', ['attr' => ['class' => 'form-control number']]);
    }
}
