@extends('layout.login')
@section('content')
<div class="login-form">
    <!--begin::Form-->
    <form method="POST" class="form" id="kt_login_singin_form" action="{{ route('login.post') }}">
        @csrf
        <!--begin::Title-->
        <div class="pb-5 pb-lg-15 text-center">
            <img src="img/logo2.png" class="max-h-70px mb-5" alt="" />
            <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg text-center">Sign In
            </h3>
            <div class="text-muted font-weight-bold font-size-h4 text-center">
                Enter your username and password to log in
            </div>
        </div>
        <!--begin::Title-->
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Error!</strong> {{ $errors->first() }}
        </div>
        @endif
        <!--begin::Form group-->
        <div class="form-group pb-5">
            {{-- <label class="font-size-h6 font-weight-bolder text-dark">Username</label> --}}
            <input class="form-control h-auto py-7 px-6 rounded-lg border-0" type="text" name="username" autocomplete="off" required placeholder="Username"/>
        </div>
        <!--end::Form group-->
        <!--begin::Form group-->
        <div class="form-group">
            <div class="d-flex justify-content-between mt-n5">
                {{-- <label class="font-size-h6 font-weight-bolder text-dark pt-5">Password</label> --}}
                <!-- <a href="custom/pages/login/login-3/forgot.html" class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5">Forgot Password ?</a> -->
            </div>
            <input class="form-control h-auto py-7 px-6 rounded-lg border-0" type="password" name="password" autocomplete="off" required placeholder="Password"/>
        </div>
        <!--end::Form group-->
        <!--begin::Action-->
        <div class="pb-lg-0 pb-5 d-flex justify-content-center">
            <button type="submit" id="kt_login_singin_form_submit_button" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Login</button>
        </div>
        <!--end::Action-->
    </form>
    <!--end::Form-->
</div>
@endsection
@section('scripts')
<script>
    var _buttonSpinnerClasses = 'spinner spinner-right spinner-white pr-15';
    var form = KTUtil.getById('kt_login_singin_form');
    var f = $('#kt_login_singin_form');
    var formSubmitButton = KTUtil.getById('kt_login_singin_form_submit_button');
    var fsb = $('#kt_login_singin_form_submit_button');

    f.submit(function(event) {
       KTUtil.btnWait(formSubmitButton, _buttonSpinnerClasses, "Please wait");
        fsb.prop('disabled', true);

        
        setTimeout(function() {
            KTUtil.btnRelease(formSubmitButton);
            fsb.prop('disabled', false);
        }, 2000);
    });
</script>
@endsection