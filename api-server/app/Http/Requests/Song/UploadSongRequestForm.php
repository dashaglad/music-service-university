<?php

namespace App\Http\Requests\Song;

use App\ApiModels\RequestModels\Song\UploadSongRequestModel;
use App\Http\Requests\CommonRequestForm;

class UploadSongRequestForm extends CommonRequestForm
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:100'],
            'file' => ['required', 'mimes:mp3']
        ];
    }

    public function body(): UploadSongRequestModel
    {
        $model = new UploadSongRequestModel();
        $model->title = $this->get('title');
        $model->file = $this->file('file');

        return $model;
    }
}
