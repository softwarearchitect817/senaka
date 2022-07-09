<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Covid19DataAddForm extends FormRequest
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
            "employee_name" => "required|string",
            "employee_id" => "required|string",
            "fever" => "required|alpha|in:yes,no",
            "cough" => "required|alpha|in:yes,no",
            "shortness_of_breath" => "required|alpha|in:yes,no",
            "trouble_in_swallowing" => "required|alpha|in:yes,no",
            "stuffy_nose" => "required|alpha|in:yes,no",
            "loss_of_taste" => "required|alpha|in:yes,no",
            "nausea_etc" => "required|alpha|in:yes,no",
            "tiredness" => "required|alpha|in:yes,no",
            "ppe" => "required|alpha|in:yes,no",
            "travelled_outside" => "required|alpha|in:yes,no",
        ];
    }

    public function getData()
    {
        return [
            "employee_name" => $this->get("employee_name"),
            "employee_id" => $this->get("employee_id"),
            "fever" => $this->get("fever"),
            "cough" => $this->get("cough"),
            "shortness_of_breath" => $this->get("shortness_of_breath"),
            "trouble_in_swallowing" => $this->get("trouble_in_swallowing"),
            "stuffy_nose" => $this->get("stuffy_nose"),
            "loss_of_taste" => $this->get("loss_of_taste"),
            "nausea_etc" => $this->get("nausea_etc"),
            "tiredness" => $this->get("tiredness"),
            "ppe" => $this->get("ppe"),
            "travelled_outside" => $this->get("travelled_outside"),
            "user_id" => auth()->user()->id,
        ];
    }

}
