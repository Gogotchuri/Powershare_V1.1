@extends('blades.layouts.app')

@section('body')
    <body>
    </body>
    <script>
        @if($error)
            window.opener.postMessage({ error: "{{ $error }}" }, "{{ url('/') }}");
            window.close();
        @else
            window.opener.postMessage({ token: "{{ $token }}" }, "{{ url('/') }}");
            window.close();
        @endif

    </script>
@endsection