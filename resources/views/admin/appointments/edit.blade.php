@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.appointment.title_singular') }}
        </div>

        <div class="card-body">
            <form action="{{ route('admin.appointments.update', [$appointment->id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name">{{ trans('cruds.appointment.fields.name') }}</label>
                    <input type="text" id="name" name="name" class="form-control"
                        value="{{ old('name', isset($appointment) ? $appointment->name : '') }}">
                    @if ($errors->has('name'))
                        <em class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.appointment.fields.name_helper') }}
                    </p>
                </div>
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">{{ trans('cruds.appointment.fields.email') }}</label>
                    <input type="email" id="email" name="email" class="form-control"
                        value="{{ old('email', isset($appointment) ? $appointment->email : '') }}">
                    @if ($errors->has('name'))
                        <em class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </em>
                    @endif

                </div>
                <div class="form-group {{ $errors->has('number') ? 'has-error' : '' }}">
                    <label for="number">Mobile Number</label>
                    <input type="tel" id="number" name="number" class="form-control"
                        value="{{ old('number', isset($appointment) ? $appointment->number : '') }}">
                    @if ($errors->has('number'))
                        <em class="invalid-feedback">
                            {{ $errors->first('number') }}
                        </em>
                    @endif

                </div>
                <div class="form-group {{ $errors->has('start_time') ? 'has-error' : '' }}">
                    <label for="start_time">InterView Date*</label>
                    <input type="text" id="start_time" name="start_time" class="form-control datetime"
                        value="{{ old('start_time', isset($appointment) ? $appointment->start_time : '') }}">
                    @if ($errors->has('start_time'))
                        <em class="invalid-feedback">
                            {{ $errors->first('start_time') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.appointment.fields.start_time_helper') }}
                    </p>
                </div>


                <div class="form-group {{ $errors->has('comments') ? 'has-error' : '' }}">
                    <label for="comments">{{ trans('cruds.appointment.fields.comments') }}</label>
                    <textarea id="comments" name="comments"
                        class="form-control ">{{ old('comments', isset($appointment) ? $appointment->comments : '') }}</textarea>
                    @if ($errors->has('comments'))
                        <em class="invalid-feedback">
                            {{ $errors->first('comments') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.appointment.fields.comments_helper') }}
                    </p>
                </div>
                <div class="form-group {{ $errors->has('Department') ? 'has-error' : '' }}">
                    <label for="department">Department
                        <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                    <select name="services[]" id="services" class="form-control select2" multiple="multiple">
                        @foreach ($services as $id => $services)
                            <option value="{{ $id }}"
                                {{ in_array($id, old('services', [])) || (isset($appointment) && $appointment->services->contains($id))? 'selected': '' }}>
                                {{ $services }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('services'))
                        <em class="invalid-feedback">
                            {{ $errors->first('services') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.appointment.fields.services_helper') }}
                    </p>
                </div>
                <div class="form-group {{ $errors->has('have_called') ? 'has-error' : '' }}">
                    <label for="called">Call</label>
                    <select name="called" id="call" class="form-control select2">

                        <option {{ $appointment->called == 'no' ? 'selected' : '' }} value="no">Not Yet</option>
                        <option {{ $appointment->called == 'yes' ? 'selected' : '' }} value="yes">Yes</option>
                        <option {{ $appointment->called == 'no_answer' ? 'selected' : '' }} value="no_answer"> No Answer
                        </option>

                    </select>

                </div>
                <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control select2">

                        <option {{ $appointment->status == 'processing' ? 'selected' : '' }} value="processing">
                            Processing</option>
                        <option {{ $appointment->status == 'accepted' ? 'selected' : '' }} value="accepted">accepted
                        </option>
                        <option {{ $appointment->status == 'semi-reject' ? 'selected' : '' }} value="semi-reject">
                            Semi-reject</option>

                        <option value="rejected">rejected</option>

                    </select>
                    @if ($errors->has('client_id'))
                        <em class="invalid-feedback">
                            {{ $errors->first('client_id') }}
                        </em>
                    @endif
                </div>
                <div>
                    <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
                </div>
            </form>


        </div>
    </div>
@endsection
