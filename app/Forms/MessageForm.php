<?php

namespace App\Forms;

use App\Models\Group;
use App\Models\Session;
use Illuminate\Support\Facades\Auth;
use Kris\LaravelFormBuilder\Form;

class MessageForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('session_id', 'choice', [
                'choices' => $this->getSessions(),
                'empty_value' => 'Choose Session',
                'label' => 'Session', 'attr' => ['class' => 'form-control select2']
            ])
            ->add('group_id', 'choice', [
                'choices' => $this->getGroups(),
                'empty_value' => 'Choose Group',
                'label' => 'Group', 'attr' => ['class' => 'form-control select2']
            ])
            ->add('phones', 'textarea', ['label' => 'Number (example: 628xxx,628xxx,628xxx)', 'attr' => ['placeholder' => 'Silahkan masukan No tujuan']])
            ->add('text', 'textarea', ['attr' => ['class' => 'form-control']])
            ->add('file', 'file', ['attr' => ['class' => 'form-control number']])
            ->add('submit', 'submit', ['label' => 'Submit', 'attr' => ['class' => 'btn btn-success']]);
    }

    public function getSessions()
    {
        $sessions = Session::whereCompanyId(Auth::user()->company_id)->get();
        $data = [];
        foreach ($sessions as $session) {
            $data[$session->id] = $session->name;
        }
        return $data;
    }

    public function getGroups()
    {
        $groups = Group::whereCompanyId(Auth::user()->company_id)->get();
        $data = [];
        foreach ($groups as $group) {
            $data[$group->id] = $group->name;
        }
        return $data;
    }
}
