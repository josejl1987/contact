@extends('scaffold-interface.layouts.defaultMaterialize')
@section('title','Index')
@section('content')

<div class = 'container'>
    <h1>
    My contact book
    </h1>

    <div class="row">
        <form class = 'col s3' method = 'get' action = '{!!url("contact")!!}/create'>
            <button class = 'btn red' type = 'submit'>Add a new contact</button>
        </form>

        <!-- Modal Trigger -->
        <a class="modal-trigger waves-effect waves-light btn" href="#searchModal">Search</a>

        <!-- Modal Structure -->
        <div id="searchModal" class="modal">
            <div class="modal-content">

                <form method = 'GET' action = '{!!url("contact")!!}'>
                    <input type = 'hidden' name = '_token' value = '{{ Session::token() }}'>
                    <div class="input-field col s12">
                        {{Form::text('name',null,['class'=>'validate'])}}
                        {{Form::label('name','Name')}}
                    </div>
                    <div class="input-field col s12">
                        {{Form::text('surname',null,['class'=>'validate'])}}
                        {{Form::label('surname','Surname')}}
                    </div>
                    <div class="input-field col s12">
                        {{Form::email('email',null,['class'=>'validate'])}}
                        {{Form::label('email','Email')}}

                    </div>
                    <div class="input-field col s12">

                        {{Form::text('phone',null,['class'=>'validate'])}}
                        {{Form::label('phone','Phone number')}}
                    </div>
                    {{Form::label('Groups','Groups')}}

                    <div class="input-field col s12">
                        {{Form::select('groups[]', \App\Group::all()->pluck('name','id'), null, ['class'=>'browser-default','multiple' => true])}}
                    </div>
                    <br>
                    <button class = 'btn red' type ='submit'>Search</button>

                </form>


            </div>
            <div class="modal-footer">
            </div>
        </div>

    </div>




    <table>
        <thead>
            <th>Name</th>
            <th>Surname</th>
            <th>Email address</th>
            <th>Phone Number</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
            <tr>
                <td>{!!$contact->name!!}</td>
                <td>{!!$contact->surname!!}</td>
                <td>{!!$contact->email!!}</td>
                <td>{!!$contact->phone!!}</td>
                <td>
                    <div class = 'row'>
                        <a href = '#modal1' class = 'delete btn-floating modal-trigger red' data-link = "/contact/{!!$contact->id!!}/deleteMsg" ><i class = 'material-icons'>delete</i></a>
                        <a href = '#' class = 'viewEdit btn-floating blue' data-link = '/contact/{!!$contact->id!!}/edit'><i class = 'material-icons'>edit</i></a>
                        <a href = '#' class = 'viewShow btn-floating orange' data-link = '/contact/{!!$contact->id!!}'><i class = 'material-icons'>info</i></a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $contacts->render() !!}

</div>
@endsection