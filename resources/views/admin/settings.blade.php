@extends('layouts.admin')

@section('content')
    <style>
        .text-danger {
            font-size: initial;
            line-height: 36px;
        }

        .alert {
            font-size: initial;
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Setting</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Setting</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="col-lg-12">
                    <div class="page-content my-account__edit">
                        <div class="my-account__edit-form">
                            <form name="account_edit_form" action="{{ route('admin.setting.update') }}" method="POST"
                                class="form-new-product form-style-1 needs-validation" novalidate="" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <fieldset>
                                    <div class="body-title">Upload images <span class="tf-color-1">*</span>
                                    </div>
                                    <div class="upload-image flex-grow">
                                        @if($user->image)
                                            <div class="item" id="imgpreview">
                                                <img src="{{asset('uploads/users')}}/{{$user->image}}" class="effect8" alt="">
                                            </div>
                                        @endif
                                        <div id="upload-file" class="item up-load">
                                            <label class="uploadfile" for="myFile">
                                                <span class="icon">
                                                    <i class="icon-upload-cloud"></i>
                                                </span>
                                                <span class="body-text">Drop your images here or select <span
                                                        class="tf-color">click to browse</span></span>
                                                <input type="file" id="myFile" name="image" accept="image/*">
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                                @error('image') <span class="alert alert-danger text-center">{{$message}} </span> @enderror
                                
                                <fieldset class="name">
                                    <div class="body-title">Name <span class="tf-color-1">*</span>
                                    </div>
                                    <input class="flex-grow" type="text" placeholder="Full Name" name="name" tabindex="0"
                                        value="{{ $user->name }}" aria-required="true" required="">
                                </fieldset>
                                @error('name') <span class="alert alert-danger text-center">{{$message}} </span> @enderror

                                <fieldset class="name">
                                    <div class="body-title">Mobile Number <span class="tf-color-1">*</span></div>
                                    <input class="flex-grow" type="text" placeholder="Mobile Number" name="mobile"
                                        tabindex="0" value="{{ $user->mobile }}" aria-required="true" required="">
                                </fieldset>
                                @error('mobile') <span class="alert alert-danger text-center">{{$message}} </span> @enderror

                                <fieldset class="name">
                                    <div class="body-title">Email Address <span class="tf-color-1">*</span></div>
                                    <input class="flex-grow" type="text" placeholder="Email Address" name="email"
                                        tabindex="0" value="{{ $user->email }}" aria-required="true" required="">
                                </fieldset>
                                @error('email') <span class="alert alert-danger text-center">{{$message}} </span> @enderror

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="my-3 bot">
                                            <div></div>
                                            <button type="submit" class="btn btn-primary tf-button w208">Save
                                                Changes</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function(){
            $("#myFile").on("change", function(e){
                const photoInp = $("#myFile");
                const [file] = this.files;
                if(file)
                {
                    $("#imgpreview img").attr('src',URL.createObjectURL(file));
                    $("#imgpreview").show();
                }
            });
            $("input[name='name']").on("change",function(){
                $("input[name='slug']").val(StringToSlug($(this).val()));
            });
        });
        function StringToSlug(Text)
        {
            return Text.toLowerCase()
            .replace(/[^\w ]+/g,"")
            .replace(/ +/g,"-");
        }
    </script>
@endpush