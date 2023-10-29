@extends('layouts.master-layouts')
@section('title')
    @if ($room)
        {{ __('Update Room Details') }}
    @else
        {{ __('Add New Room') }}
    @endif
@endsection
@section('body')

    <body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">
                        @if ($room)
                            {{ __('Update Room Details') }}
                        @else
                            {{ __('Add New Room') }}
                        @endif
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('room') }}">{{ __('Rooms') }}</a></li>
                            <li class="breadcrumb-item active">
                                @if ($room)
                                    {{ __('Update Room Details') }}
                                @else
                                    {{ __('Add New Room') }}
                                @endif
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <a href="{{ url('room') }}">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Room List') }}
                    </button>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote>{{ __('Basic Information') }}</blockquote>
                        <form action="@if ($room ) {{ url('room/' . $room->id) }} @else {{ route('room.store') }} @endif" method="post" enctype="multipart/form-data">
                            @csrf
                            @if ($room )
                                <input type="hidden" name="_method" value="PATCH" />
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Room Name ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                name="name" id="Name" tabindex="1"
                                                value="@if ($room){{ old('name', $room->name) }}@elseif(old('name')){{ old('name') }}@endif"
                                                placeholder="{{ __('Enter Room Name') }}">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Description') }}</label>
                                            <textarea id="Description" name="description" tabindex="7"
                                                    class="form-control @error('description') is-invalid @enderror" rows="3"
                                                    placeholder="{{ __('Enter Description') }}">@if ($room){{ $room->description }}@elseif(old('description')){{ old('description') }}@endif</textarea>
                                            @error('duration')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Status ') }}<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control @error('status') is-invalid @enderror"
                                                tabindex="11" name="status">
                                                <option selected disabled>{{ __('-- Select Status --') }}</option>
                                                <option value="1" @if (($room && $room->status == '1') || old('status') == '1') selected @endif>{{ __('Active') }}</option>
                                                <option value="0" @if (($room && $room->status == '0') || old('status') == '0') selected @endif>{{ __('In Active') }}</option>
                                            </select>
                                            @error('status')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        @if ($room)
                                            {{ __('Update Room Details') }}
                                        @else
                                            {{ __('Add New Room') }}
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    @endsection
    @section('script')
        <script>
            // Script
        </script>
    @endsection
