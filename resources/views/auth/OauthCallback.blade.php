@extends('blades.layouts.app')

@section('body')
    <body>
    </body>
    <script>
        window.opener.postMessage({ token: "{{ $token }}" }, "{{ url('/') }}");
        console.log("{{$token}}");
        window.close();
    </script>
@endsection