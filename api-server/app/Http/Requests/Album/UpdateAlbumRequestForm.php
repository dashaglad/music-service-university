<?php

namespace App\Http\Requests\Album;

use App\ApiModels\RequestModels\Album\UpdateAlbumRequestModel;
use App\Http\Requests\CommonRequestForm;

class UpdateAlbumRequestForm extends CommonRequestForm
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['nullable', 'max:20', 'string'],
            'description' => ['nullable', 'max:100', 'string']
        ];
    }

    public function body(): UpdateAlbumRequestModel
    {
        return $this->innerBodyObject(new UpdateAlbumRequestModel());
    }
}
