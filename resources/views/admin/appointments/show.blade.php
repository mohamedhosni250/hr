@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.appointment.title') }}
        </div>

        <div class="card-body">
            <div class="mb-2">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.appointment.fields.id') }}
                            </th>
                            <td>
                                {{ $appointment->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.appointment.fields.client') }}
                            </th>
                            <td>
                                {{ $appointment->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.appointment.fields.email') }}
                            </th>
                            <td>
                                {{ $appointment->email ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.appointment.fields.start_time') }}
                            </th>
                            <td>
                                {{ $appointment->start_time }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Mobile Number
                            </th>
                            <td>
                                {{ $appointment->number }} <a id="notify" class="btn btn-primary"> Send
                                    Message</a>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Uploaded CV
                            </th>
                            <td>
                                <a href="{{ URL::to('/') . '/storage/' . $appointment->file_path }}"> download
                                    cv</a>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.appointment.fields.comments') }}
                            </th>
                            <td>
                                {!! $appointment->comments !!}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Services
                            </th>
                            <td>
                                @foreach ($appointment->services as $id => $services)
                                    <span class="label label-info label-many">{{ $services->name }}</span>
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
                <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>


        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#notify').click(function(e) {

            console.log('gisbu');
        });
    </script>
@endpush
