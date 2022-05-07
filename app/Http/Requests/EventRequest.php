<?php

namespace App\Http\Requests;

use App\Models\Event;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class EventRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public $event_start;
    public $event_end;
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'event_start' => ['required', 'date:Y-m-d H:i'],
            'event_end' => ['required', 'date:Y-m-d H:i'],
            'users' => ['array'],
        ];
    }

    /**
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {

        $validator->after(function ($validator) {
            try {
                $event_start = Carbon::parse($this->input('event_start'))->setTimezone('UTC')->getTimestamp();
                $event_end = Carbon::parse($this->input('event_end'))->setTimezone('UTC')->getTimestamp();

                if (($event_end - $event_start) < Event::THIRTY_MIN || ($event_end - $event_start) > Event::DAY
                || $event_end < $event_start) {
                    $validator->errors()->add('date_interval', 'Specify the correct interval for the start and end of the event');
                }

                $this->event_start = $event_start;
                $this->event_end = $event_end;
            } catch (Exception $e) {
                $validator->errors()->add('date_type', 'Incorrect type date');
            }
        });
    }
}
