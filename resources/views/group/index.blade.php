@extends('scaffold-interface.layouts.defaultMaterialize')
@section('title','Index')
@section('content')

<div class = 'container'>
    <h1>
        group Index
    </h1>
    <div class="row">
        <form class = 'col s3' method = 'get' action = '{!!url("group")!!}/create'>
            <button class = 'btn red' type = 'submit'>Create New group</button>
        </form>
    </div>
    <table>
        <thead>
            <th>name</th>
            <th>actions</th>
        </thead>
        <tbody>
            @foreach($groups as $group) 
            <tr>
                <td>{!!$group->name!!}</td>
                <td>
                    <div class = 'row'>
                        <a href = '#modal1' class = 'delete btn-floating modal-trigger red' data-link = "/group/{!!$group->id!!}/deleteMsg" ><i class = 'material-icons'>delete</i></a>
                        <a href = '#' class = 'viewEdit btn-floating blue' data-link = '/group/{!!$group->id!!}/edit'><i class = 'material-icons'>edit</i></a>
                        <a href = '#' class = 'viewShow btn-floating orange' data-link = '/group/{!!$group->id!!}'><i class = 'material-icons'>info</i></a>
                    </div>
                </td>
            </tr>
            @endforeach 
        </tbody>
    </table>
    {!! $groups->render() !!}

</div>
@endsection