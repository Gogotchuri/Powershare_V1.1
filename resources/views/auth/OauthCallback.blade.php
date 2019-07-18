@extends('blades.layouts.app')

@section('body')
    <body>
    </body>
    <script>
        window.opener.postMessage({ token: "{{ $token }}" }, "{{ url('/') }}");
        window.close();
    </script>
@endsection