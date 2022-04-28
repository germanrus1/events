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

    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'event_start' => ['required', 'date:Y-m-d H:i'],
            'event_end' => ['required', 'date:Y-m-d H:i'],
            'user_id' => ['required', 'integer'],
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
                $event_start = Carbon::createFromFormat('Y-m-d H:i', $this->input('event_start'))->getTimestamp();
                $event_end = Carbon::createFromFormat('Y-m-d H:i', $this->input('event_end'))->getTimestamp();
                if ($event_end < ($event_start + Event::THIRTY_MIN) && $event_end > ($event_start + Event::DAY)) {
                    $validator->errors()->add('date_interval', 'Specify the correct interval for the start and end of the event' . $event_end  . '  '. $event_start);
                }
            } catch (Exception $e) {
                $validator->errors()->add('date_type', 'Incorrect type date' . $this->input('event_start')  . '  '. $this->input('event_end'));
            }
        });
    }
}
