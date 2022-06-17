<?php

namespace App\Traits;

use Kris\LaravelFormBuilder\Facades\FormBuilder;
use Spatie\Html\Facades\Html;
use Proengsoft\JsValidation\Facades\JsValidatorFacade;

trait XIForm
{
    protected function action_button($data, $btn_label = 'Action')
    {
        $buttons = '';
        foreach ($data as $key => $value) {
            $attribute = (!empty($value['attribute'])) ? $value['attribute'] : [];
            $attribute_default = ['class' => 'dropdown-item'];
            $attribute = array_merge($attribute_default, $attribute);
            switch (@$value['type']) {
                case 'delete':
                    $title = (!empty($value['label'])) ? $value['label'] : 'Delete';
                    $buttons .=
                        FormBuilder::open(['method' => 'DELETE', 'url' => $value['action'], 'class' => 'validate-form', 'data-confirm' => 'Anda yakin menghapus data ini?']) .
                        FormBuilder::submit($title, ['class' => 'btn btn-danger btn-block', 'style' => 'text-align:left']) .
                        FormBuilder::close();
                    break;

                case 'edit':
                    $title = (!empty($value['label'])) ? $value['label'] : 'Edit';
                    $buttons .= Html::link($value['action'], $title, $attribute) . '</li>';
                    break;

                case 'detail':
                    $title = (!empty($value['label'])) ? $value['label'] : 'Detail';
                    $buttons .= Html::link($value['action'], $title, $attribute) . '</li>';
                    break;

                case 'divider':
                    $buttons .= '<div class="dropdown-divider"></div>';
                    break;

                default:
                    $route = (!empty($value['route'])) ?? $this->module . '.edit';
                    $title = (!empty($value['label'])) ? $value['label'] : 'Action';
                    $buttons .= Html::link($value['action'], $title, $attribute);
                    break;
            }
        }
        return '
		<div class="btn-group">
				<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						' . $btn_label . '
				</button>
				<div class="dropdown-menu">
						' . $buttons . '
				</div>
		</div>';
    }

    protected static function icon_button($data, $isGroup = false, $btn_label = 'Action')
    {
        $buttons = [];
        $input = '';
        foreach ($data as $key => $value) {
            $attribute = (!empty($value['attribute'])) ? $value['attribute'] : [];
            $class = (!empty($value['class'])) ? $value['class'] : '';
            $class = ($isGroup) ? 'dropdown-item ' . $class : $class;
            $confirm = (!empty($value['confirm'])) ? 'data-confirm="' . $value['confirm'] . '"' : '';
            $form = '';
            if (!empty($value['form_layout'])) {
                $form = view($value['form_layout'], array_merge(data_get($value, 'data', []), ['form' => data_get($value, 'form', [])]))->render();
            } else if (!empty($value['form'])) {
                $form = form($value['form'], ['class' => 'form-container', 'id' => 'popupForm']);
            }
            $form .= (!empty($value['validation'])) ? JsValidatorFacade::formRequest($value['validation'], '.swal2-container.swal2-shown .form-container') : '';
            switch (@$value['type']) {
                case 'reject':
                case 'delete':
                    $title = (!empty($value['label'])) ? $value['label'] : 'Reject';
                    $attribute_default = [];
                    $attribute = array_merge($attribute_default, $attribute);
                    $buttons[] = '<a href="' . $value['route'] . '" class="btn btn-danger ' . $class . '" ' . self::generateAttribute($attribute) . ' data-method="DELETE" ' . $confirm . ' data-action="' . $value['route'] . '" data-label="' . $title . '"><i class="fa fa-times"></i> ' . $title . '<div class="hide">' . $form . '</div></a>';
                    break;

                case 'accept':
                    $title = (!empty($value['label'])) ? $value['label'] : 'Accept';
                    $attribute_default = [];
                    $attribute = array_merge($attribute_default, $attribute);
                    $buttons[] = '<a href="' . $value['route'] . '" class="btn btn-success ' . $class . '" ' . self::generateAttribute($attribute) . ' data-method="PATCH" ' . $confirm . ' data-action="' . $value['route'] . '" data-label="' . $title . '"><i class="fa fa-check"></i> ' . $title . '<div class="hide">' . $form . '</div></a>';
                    break;

                case 'info':
                    $title = (!empty($value['label'])) ? $value['label'] : 'Action';
                    $action = (!empty($value['action'])) ? $value['action'] : 'info';
                    $method = (!empty($value['method'])) ? $value['method'] : 'POST';
                    $info = data_get($value, 'info', $title);
                    $icon = (!empty($value['icon'])) ? '<i class="fa fa-' . $value['icon'] . '"></i> ' : '';
                    $attribute_default = [];
                    $attribute = array_merge($attribute_default, $attribute);
                    $buttons[] = '<a href="#" class="btn btn-' . $action . ' ' . $class . '" ' . data_get($value, 'attr') . ' ' . self::generateAttribute($attribute) . ' data-info="' . $info . '" data-label="' . $title . '">' . $icon . '' . $title . '<div class="hide">' . $form . '</div></a>';
                    break;

                default:
                    $title = (!empty($value['label'])) ? $value['label'] : 'Action';
                    $action = (!empty($value['action'])) ? $value['action'] : 'info';
                    $method = (!empty($value['method'])) ? $value['method'] : 'POST';
                    $icon = (!empty($value['icon'])) ? '<i class="fa fa-' . $value['icon'] . '"></i> ' : '';
                    $attribute_default = [];
                    $attribute = array_merge($attribute_default, $attribute);
                    $buttons[] = '<a href="' . $value['route'] . '" class="btn btn-' . $action . ' ' . $class . '" ' . self::generateAttribute($attribute) . ' data-method="' . $method . '" ' . $confirm . ' data-action="' . $value['route'] . '" data-label="' . $title . '">' . $icon . '' . $title . '<div class="hide">' . $form . '</div></a>';
                    break;
            }
        }
        if ($isGroup) {
            return '<div class="btn-group dropdown-action-btn">
			<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			  ' . $btn_label . '
			</button>
			<div class="dropdown-menu">
			' . implode(' ', $buttons) . '
			</div>
		  </div>';
        } else {
            return implode(' ', $buttons);
        }
    }

    protected static function itemDetail($data, $description = "")
    {
        return '<a href="#" data-image="' . $data->image . '" data-url="' . $data->url . '" data-title="' . $data->name . '" data-description="' . $description . '" class="item-detail" target="_blank">' . $data->name . '</a>';
    }

    protected static function generateAttribute($attributes)
    {
        return join(' ', array_map(function ($key) use ($attributes) {
            if (is_bool($attributes[$key])) {
                return $attributes[$key] ? $key : '';
            }
            return $key . '="' . $attributes[$key] . '"';
        }, array_keys($attributes)));
    }
}
