<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JsonMapper;

abstract class CommonRequestForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [];
    }

    abstract public function body(): mixed;

    protected function innerBodyObject(mixed $body): mixed
    {
        $jsonMapper = new JsonMapper();
        $jsonMapper->bEnforceMapType = false;

        return $jsonMapper->map($this->input(), $body);
    }

    protected function innerBodyArray(string $itemClass): array
    {
        $jsonMapper = new JsonMapper();
        $jsonMapper->bEnforceMapType = false;

        $data = (array)$this->input();

        return array_map(fn($item) => $jsonMapper->map((object)$item, new $itemClass()), $data);
    }
}
