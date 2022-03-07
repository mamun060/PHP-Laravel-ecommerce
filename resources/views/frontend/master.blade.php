<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) ?? 'en' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title','Salon Booking Management')</title>

    {{-- main css goes here --}}
    
    {{-- main css goes here --}}
    @stack('css')

</head>

<body>

    @hasSection('content')
        @yield('content')
    @endIf

    @sectionMissing('content')
        <div class="py-5 mx-5">
            <h2 class="text-center text-uppercase font-weight-bold display-5 alert alert-danger alert-heading">No content Found</h2>
        </div>
    @endIf

</body>

@stack('js')

</html>