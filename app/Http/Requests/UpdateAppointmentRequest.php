<?php

namespace App\Http\Requests;

use App\Appointment;
use Gate;
use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateAppointmentRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('appointment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return  [
            'client_id'   => [

                'integer',
            ],
            'start_time'  => [

                // 'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
            ],
            'services.*'  => [
                'integer',
            ],
            'services'    => [
                'array',
            ],
            'name' => [
                'string'
            ],
            'email' => [
                'email'
            ],
            'number' => [
                'required'
            ],
            'called' => [],
            'status' => []
        ];
    }
}
