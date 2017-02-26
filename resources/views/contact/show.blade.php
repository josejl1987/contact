@extends('scaffold-interface.layouts.defaultMaterialize')
@section('title','Show')
@section('content')

<div class = 'container'>
    <h1>
        Show contact
    </h1>
    <form method = 'get' action = '{!!url("contact")!!}'>
        <button class = 'btn blue'>contact Index</button>
    </form>
    <table class = 'highlight bordered'>
        <thead>
            <th>Key</th>
            <th>Value</th>
        </thead>
        <tbody>
            <tr>
                <td>
                    <b><i>name : </i></b>
                </td>
                <td>{!!$contact->name!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>surname : </i></b>
                </td>
                <td>{!!$contact->surname!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>email : </i></b>
                </td>
                <td>{!!$contact->email!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>phone : </i></b>
                </td>
                <td>{!!$contact->phone!!}</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection