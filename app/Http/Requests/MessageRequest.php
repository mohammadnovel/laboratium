<?php

namespace App\Http\Requests;

use App\Models\GroupPhone;
use App\Models\Message;
use App\Services\BalanceService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'session_id' => 'required',
            'text' => 'required',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->group_id == null && $this->phones == null) {
                $validator->errors()->add('phones', 'Silahkan pilih salah satu daripada Group dan Number untuk No Whatsapp tujuan');
            }

            if ($this->group_id != null || $this->phones != null) {
                $user = Auth::user();
                $message_new = 0;
                $message_max = intval(config('status.message_max'));
                $message_count = Message::query()
                    ->whereCompanyId($user->company_id)
                    ->whereDate('created_at', date('Y-m-d'))
                    ->where('status', '<=', 2)
                    ->count();

                if ($this->group_id != null) {
                    $message_new = GroupPhone::whereGroupId($this->group_id)->count();
                }

                if ($this->phones != null) {
                    $phones = explode(",", rtrim($this->phones, ','));
                    foreach ($phones as $phone) {
                        if (is_int(intval($phone)) == false || intval($phone) == 0) {
                            $validator->errors()->add('phones', 'Phone format only');
                        }
                    }
                    $message_new = count($phones);
                }

                $price = data_get($user, 'company.price', 0);
                $total_price = $price * $message_new;
                $balance = BalanceService::getBalance();
                if ($total_price > $balance) {
                    $validator->errors()->add('phones', 'Saldo tidak cukup, kirim pesan ini membutuhkan biaya ' . number_format($total_price));
                }

                $message_total = $message_count + $message_new;
                if ($message_total > $message_max) {
                    $validator->errors()->add('phones', 'Sisa pesan hari ini adalah ' . ($message_max - $message_count));
                }
            }


            return $validator;
        });
    }
}
