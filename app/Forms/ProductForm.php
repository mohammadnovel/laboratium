<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use App\Models\Location;

class ProductForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('sku', 'text', ['attr' => ['class' => 'form-control']])
            ->add('title', 'text', ['attr' => ['class' => 'form-control']])
            ->add('sub_title', 'text', ['attr' => ['class' => 'form-control']])
            ->add('description', 'textarea', ['label' => 'Description', 'attr' => ['placeholder' => 'Description', 'rows'=>10, 'class' => 'textarea-edit']])
            ->add('contact_person', 'text', ['attr' => ['class' => 'form-control']])
            ->add('location', 'text', ['attr' => ['class' => 'form-control'], 'rules' => 'required',
            'error_messages' => [
                'contact_person.required' => 'The title field is mandatory.'
            ]])
            ->add('location_id', 'choice', [
                'choices' => $this->getLocation(),
                'label' => 'Location',
                'empty_value' => 'Pilih Lokasi',
                'attr' => ['class' => 'form-control select2', 'data-type' => 'sender']
            ])
            ->add('video', 'text', ['attr' => ['class' => 'form-control'], 'label' => 'Youtube URL'])
            ->add('thumbnail', 'text', ['template' => 'layouts.form.dropify', 'label' => 'Thumbnail', 'attr' => ['data-allowed-file-extensions' => 'jpg jpeg png']])
            ->add('brochure', 'text', ['template' => 'layouts.form.dropify', 'label' => 'Brochure', 'attr' => ['data-allowed-file-extensions' => 'jpg jpeg png pdf']])
            ->add('environment', 'textarea', ['label' => 'Environment', 'attr' => ['rows'=>10, 'class' => 'textarea-edit']])
            ->add('history', 'textarea', ['label' => 'History', 'attr' => ['rows'=>10, 'class' => 'textarea-edit']])
            ->add('process', 'textarea', ['label' => 'Process', 'attr' => ['rows'=>10, 'class' => 'textarea-edit']])
            ->add('submit', 'submit', ['label' => 'Submit', 'attr' => ['class' => 'btn btn-success']]);
    }

    public function getLocation()
    {
        $locations = Location::get();
        $data = [];
        foreach ($locations as $key => $value) {
            $data[$value->id] = $value->name;
        }
        return $data;
    }
}
