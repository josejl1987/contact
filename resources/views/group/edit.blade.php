@extends('scaffold-interface.layouts.defaultMaterialize')
@section('title','Edit')
@section('content')

<div class = 'container'>
    <h1>
        Edit group
    </h1>
    <form method = 'get' action = '{!!url("group")!!}'>
        <button class = 'btn blue'>group Index</button>
    </form>
    <br>
    <form method = 'POST' action = '{!! url("group")!!}/{!!$group->
        id!!}/update'> 
        <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
        <div class="input-field col s6">
            <input id="name" name = "name" type="text" class="validate" value="{!!$group->
            name!!}"> 
            <label for="name">name</label>
        </div>
        <button class = 'btn red' type ='submit'>Update</button>
    </form>
</div>
@endsection