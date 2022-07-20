<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {{ Metronic::printAttrs('html') }} {{ Metronic::printClasses('html') }}>

<head>
    <meta charset="utf-8" />

    {{-- Title Section --}}
    <title>{{ config('app.name') }} | @yield('title', $pageTitle ?? '')</title>

    {{-- Meta Data --}}
    <meta name="description" content="@yield('page_description', $page_description ?? '')" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico') }}" />

    {{-- Fonts --}}
    {{ Metronic::getGoogleFontsInclude() }}

    {{-- Global Theme Styles (used by all pages) --}}
    @foreach(config('layout.resources.css') as $style)
    <link href="{{ config('layout.self.rtl') ? asset(Metronic::rtlCssPath($style)) : asset($style) }}" rel="stylesheet" type="text/css" />
    @endforeach

    {{-- Layout Themes (used by all pages) --}}
    @foreach (Metronic::initThemes() as $theme)
    <link href="{{ config('layout.self.rtl') ? asset(Metronic::rtlCssPath($theme)) : asset($theme) }}" rel="stylesheet" type="text/css" />
    @endforeach

    {{-- Login 3 --}}
    <link rel="stylesheet" href="{{ asset('assets/css/pages/login/login-3.css') }}">

    {{-- Includable CSS --}}
    @yield('styles')
</head>

<body {{ Metronic::printAttrs('body') }} {{ Metronic::printClasses('body') }} style="background-image: url('/img/bg.png');background-position: center;background-size: cover;">

    <!-- @if (config('layout.page-loader.type') != '')
    @include('layout.partials._page-loader')
    @endif -->

    <div class="d-flex flex-column flex-root">
        <!--begin::Login-->
        <div class="login login-3 wizard d-flex flex-column flex-lg-row justify-content-center align-items-center h-100">
            <!--begin::Aside-->
            <div class="login-aside d-flex flex-column flex-row-auto">
                <!--begin::Aside-->
                <!--begin::Content-->
                <div class="login-content flex-row-fluid d-flex flex-column p-10">
                    <!--begin::Top-->
                    <div class="text-right d-flex justify-content-center">
                        <div class="top-signin text-right d-flex justify-content-end pt-5 pb-lg-0 pb-10">
                            <!-- <span class="font-weight-bold text-muted font-size-h4">Having issues?</span>
                            <a href="javascript:;" class="font-weight-bold text-primary font-size-h4 ml-2" id="kt_login_signup">Get Help</a> -->
                        </div>
                    </div>
                    <!--end::Top-->
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-row-fluid flex-center">
                        <!--begin::Signin-->
                        @yield('content')
                        <!--end::Signin-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Login-->
        </div>

    <script>
        // var HOST_URL = "route('quick-search')";
        var HOST_URL = "";
    </script>

    {{-- Global Config (global config for global JS scripts) --}}
    <script>
        var KTAppSettings = {!! json_encode(config('layout.js'), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) !!};
    </script>

    {{-- Global Theme JS Bundle (used by all pages)  --}}
    @foreach(config('layout.resources.js') as $script)
    <script src="{{ asset($script) }}" type="text/javascript"></script>
    @endforeach

    {{-- Login 3 --}}
    <!-- <script src="{{ asset('assets/js/pages/custom/login/login-3.js') }}"></script> -->

    {{-- Includable JS --}}
    @yield('scripts')

</body>

</html>