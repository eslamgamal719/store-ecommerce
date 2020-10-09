@extends('layouts.admin')

@section('title')

@stop

@section('content')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">{{__('admin/category.main')}} </a>
                                </li>
                                <li class="breadcrumb-item"><a href=""> {{__('admin/category.categories')}} </a>
                                </li>
                                <li class="breadcrumb-item active"> {{__('admin/category.edit')}}
                                    - {{$category -> name}}
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
                                        id="basic-layout-form"> {{__('admin/category.edit category')}} </h4>
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
                                              action="{{route('admin.categories.update',$category -> id)}}"
                                              method="POST"
                                              enctype="multipart/form-data">
                                            @csrf

                                            <input name="id" value="{{$category -> id}}" type="hidden">

                                            <div class="form-group">
                                                <div class="text-center">
                                                    <img
                                                        src="{{$category-> photo_url}}"
                                                        class="rounded-circle  height-150 image-preview" alt="صورة القسم  ">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label> {{__('admin/category.image')}} </label>
                                                <label id="projectinput7" class="file center-block">
                                                    <input type="file" id="file" name="photo" class="image">
                                                    <span class="file-custom"></span>
                                                </label>
                                                @error('photo')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>


                                            <div class="form-body">
                                                <h4 class="form-section"><i
                                                        class="ft-home"></i> {{__('admin/category.category data')}}
                                                </h4>


                                                <div class="row">
                                                    @foreach(config('translatable.locales') as $locale)
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label
                                                                    for="projectinput1">{{__('admin/category.' . $locale . '.name')}}
                                                                </label>

                                                                <input type="text" id="name"
                                                                       class="form-control"
                                                                       placeholder="  "
                                                                       value="{{$category->translate($locale)->name}}"
                                                                       name="{{$locale}}[name]">

                                                                @error($locale . ".name")
                                                                <span class="text-danger">{{$message}}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="projectinput1">{{__('admin/category.slug')}}
                                                            </label>

                                                            <input type="text" id="name"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                                   value="{{$category -> slug}}"
                                                                   name="slug">

                                                            @error("slug")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row hidden" id="cats-list">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label
                                                                for="projectinput2"> {{__('admin/category.choose main category')}} </label>
                                                            <select name="parent_id" style="width:auto;"
                                                                    class="form-control">
                                                                <optgroup
                                                                    label="{{__('admin/category.choose main category')}}">
                                                                    @if($allCategories && $allCategories->count() > 0)
                                                                        @php
                                                                            if(App::getLocale() == 'ar')
                                                                                subCatRecursion($allCategories , 0 ,"←");
                                                                            else
                                                                                subCatRecursion($allCategories, 0,'→');

                                                                        @endphp
                                                                    @endif
                                                                </optgroup>
                                                            </select>
                                                            @error('parent_id')
                                                            <span class="text-danger"> {{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mt-1">
                                                        <input type="checkbox" value="1"
                                                               name="is_active"
                                                               id="switcheryColor4"
                                                               class="switchery" data-color="success"
                                                               @if($category -> is_active == 1)checked @endif/>
                                                        <label for="switcheryColor4"
                                                               class="card-title ml-1">{{__('admin/category.status')}}  </label>

                                                        @error("is_active")
                                                        <span class="text-danger"> {{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>


                                                <div class="col-md-3">
                                                    <div class="form-group mt-1">
                                                        <input type="radio"
                                                               name="type"
                                                               value="1"
                                                               data-color="success"
                                                               class="switchery"
                                                               @if($category -> parent_id == null) checked @endif

                                                        />
                                                        <label class="card-title ml-1">
                                                            {{__('admin/category.main category')}}
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group mt-1">
                                                        <input type="radio"
                                                               name="type"
                                                               value="2"
                                                               @if($category -> parent_id != null) checked @endif
                                                               class="switchery"
                                                               data-color="success"
                                                        />
                                                        <label class="card-title ml-1">
                                                            {{__('admin/category.sub category')}}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>


                                    <div class="form-actions">
                                        <button type="button" class="btn btn-warning mr-1"
                                                onclick="history.back();">
                                            <i class="ft-x"></i> {{__('admin/category.return')}}
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="la la-check-square-o"></i> {{__('admin/category.update')}}
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



@stop

@section('script')

    <script>
        $("input:radio[name='type']").change(
            function () {
                if (this.checked && this.value == '2') {
                    $('#cats-list').removeClass('hidden');
                } else {
                    $('#cats-list').addClass('hidden');
                }
            }
        );
    </script>
@stop

