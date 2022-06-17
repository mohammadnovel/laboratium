<?php

namespace App\Forms;

use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Kris\LaravelFormBuilder\Form;

class GroupForm extends Form
{
    public function buildForm()
    {
        if (Auth::user()->type == 'super-admin') {
            $this
                ->add('company_id', 'choice', [
                    'choices' => $this->getCompanies(),
                    'empty_value' => 'Choose Company',
                    'label' => 'Company', 'attr' => ['class' => 'form-control select2']
                ]);
        }

        $this
            ->add('name', 'text', ['attr' => ['class' => 'form-control']])
            ->add('submit', 'submit', ['label' => 'Submit', 'attr' => ['class' => 'btn btn-success']]);
    }

    public function getCompanies()
    {
        $companies = Company::get();
        $data = [];
        foreach ($companies as $company) {
            $data[$company->id] = $company->name;
        }
        return $data;
    }
}
