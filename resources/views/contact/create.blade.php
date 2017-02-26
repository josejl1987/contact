@extends('scaffold-interface.layouts.defaultMaterialize')
@section('title','Create')
@section('content')





<div class = 'container'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <script type="text/javascript">


        $(document).ready(function() {
            $('select').select2();
            $('select').show();
        });


    </script>


    <h1>
        Create contact
    </h1>
    <form method = 'get' action = '{!!url("contact")!!}'>
        <button class = 'btn blue'>Contact Book</button>
    </form>
    <br>


    @if (count($errors) > 0)
        <div class="red-text">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif



    <form method = 'POST' action = '{!!url("contact")!!}'>
        @include('contact.contactForm',['btnText'=>'Create'])

    </form>

</div>
@endsection