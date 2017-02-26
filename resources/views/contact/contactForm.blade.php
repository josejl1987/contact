
    <input type='hidden' name='_token' value='{{ Session::token() }}'>
    <div class="input-field col s6">
        {{Form::text('name',$contact->name,['class'=>'validate','required'=>''])}}
        {{Form::label('name','Name')}}
    </div>
    <div class="input-field col s6">
        {{Form::text('surname',$contact->surname,['class'=>'validate','required'=>''])}}
        {{Form::label('surname','Surname')}}
    </div>
    <div class="input-field col s6">
        {{Form::email('email',$contact->email,['class'=>'validate','required'=>''])}}
        {{Form::label('email','Email')}}

    </div>
    <div class="input-field col s6">

        {{Form::text('phone',$contact->phone,['class'=>'validate'])}}
        {{Form::label('phone','Phone number')}}
    </div>
    {{Form::label('Groups','Groups')}}

    <div class="input-field col s6">

        {{Form::select('groups[]', $groups, $contact->groups->pluck('id')->toArray(), ['class'=>'browser-default','multiple' => true,'required'=>''])}}
    </div>
    <br>
    <button class='btn red' type='submit'>{{$btnText}}</button>