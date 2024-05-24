<?php

namespace App\Http\Requests\Album;

use App\ApiModels\RequestModels\Album\CreateAlbumRequestModel;
use App\Http\Requests\CommonRequestForm;

class CreateAlbumRequestForm extends CommonRequestForm
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:30',
            'description' => 'required|string'
        ];
    }

    public function body(): CreateAlbumRequestModel
    {
        return $this->innerBodyObject(new CreateAlbumRequestModel());
    }
}
