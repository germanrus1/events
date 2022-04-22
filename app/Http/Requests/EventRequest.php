<?php

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'event_start' => ['required', 'date:Y-m-d H:i:s'],
            'event_end' => ['required', 'date:Y-m-d H:i:s'],
        ];
    }
}
