@extends('layouts.admin')

@section('title')
    {{__('admin/settings.edit shipping')}}
@stop

@section('content')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">{{__('admin/settings.main')}}</a>
                                </li>
                                <li class="breadcrumb-item active">{{__('admin/settings.shipping methods')}}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"
                                        id="basic-layout-form">{{__('admin/settings.edit shipping method')}}</h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                @include('dashboard.includes.alerts.success')
                                @include('dashboard.includes.alerts.errors')
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form class="form"
                                              action="{{route('update.shipping.method',$shippingMethod -> id)}}"
                                              method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')  {{-- Used In Laravel 7 when update data by PUT--}}
                                            {{--  {{method_field('PUT')}}   Used In Laravel less than 7 when update data by PUT--}}

                                            <input type="hidden" name="id" value="{{$shippingMethod -> id}}">

                                            <div class="form-body">

                                                <div class="row">
                                                    @foreach(config('translatable.locales') as $locale)
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label
                                                                    for="projectinput1"> {{__('admin/settings.' . $locale . '.shipping name')}} </label>
                                                                <input type="text"
                                                                       value="{{$shippingMethod->translate($locale)->value ?? ''}}"
                                                                       id="name"
                                                                       class="form-control"
                                                                       placeholder=""
                                                                       name="{{$locale}}[value]">
                                                                @error($locale . ".value")
                                                                <span class="text-danger">{{$message}}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="projectinput1">{{__('admin/settings.shipping value')}}</label>
                                                            <input type="number"
                                                                   value="{{$shippingMethod->plain_value}}"
                                                                   id="plain_value"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                                   name="plain_value">
                                                            @error("plain_value")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-actions">
                                                    <button type="button" class="btn btn-warning mr-1"
                                                            onclick="history.back();">
                                                        <i class="ft-x"></i> {{__('admin/settings.return')}}
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="la la-check-square-o"></i> {{__('admin/settings.save')}}
                                                    </button>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic form layout section end -->
            </div>
        </div>
    </div>


@stop
