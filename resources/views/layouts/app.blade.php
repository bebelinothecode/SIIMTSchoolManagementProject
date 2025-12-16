 <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js@11.0.2/public/assets/scripts/choices.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js@11.0.2/public/assets/styles/choices.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>  
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div id="app">

        @include('layouts.navbar')
        
        <div class="main flex flex-wrap justify-end mt-16">
            
            @include('layouts.sidebar')

            <div class="content w-full sm:w-5/6">
                <div class="container mx-auto p-4 sm:p-6">

                    @yield('content')
                    
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        $(function() {
            $( "#opennavdropdown" ).on( "click", function() {
                $( "#navdropdown" ).toggleClass( "hidden" );
            })
        })
    </script>

    @stack('scripts')
    @stack('select_form')

    @if(session('open_receipt'))
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const url = @json(session('open_receipt'));
        // try to open receipt in new tab
        const newWin = window.open(url, '_blank');

        // fallback if popup blocked
        if (!newWin || newWin.closed || typeof newWin.closed === 'undefined') {
            const notice = document.createElement('div');
            notice.innerHTML = 'Receipt attempted to open in a new tab. If it did not open, <a href="'+url+'" target="_blank" class="underline text-blue-600">click here</a>.';
            notice.className = 'fixed bottom-4 right-4 bg-yellow-100 border border-yellow-300 p-3 rounded shadow';
            document.body.appendChild(notice);
            // auto-remove after 10s
            setTimeout(() => notice.remove(), 10000);
        }
    });
    </script>
    @endif
</body>
</html>