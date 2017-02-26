@extends('scaffold-interface.layouts.defaultMaterialize')
@section('title','Edit')
@section('content')

<div class = 'container'>



    <h1>
        Edit contact
    </h1>
    <form method = 'GET' action = '{!!url("contact")!!}'>
        <button class = 'btn blue'>Index</button>
    </form>
    <br>
    <form method = 'POST' action = '{!! url("contact")!!}/{!!$contact->id!!}/update'>
        @include('contact.contactForm',['btnText'=>'Update'])
    </form>

</div>
@endsection