<?php

namespace App\Http\Requests;

use App\ApiModels\RequestModels\LoginRequestModel;

class LoginRequestForm extends CommonRequestForm
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string',
            'password' => 'required|string'
        ];
    }

    public function body(): LoginRequestModel
    {
        return $this->innerBodyObject(new LoginRequestModel());
    }
}
