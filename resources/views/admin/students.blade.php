@extends('layouts.myApp')
@section('content')

<h3>Student list for {{ session('semester') }}</h3>

<br/>

<table style='margin-bottom: 30px;'>
    <tr>
        <td>Number of students : {{ $students->count() }}</td>
        <td>Vassar : {{ $vassar }}</td>
        <td>Wesleyan : {{ $wesleyan }}</td>
        <td>Other : {{ $other }}</td>
        <td>
          @if (in_array(4, Auth::user()->access))
            <a href='{{ route("student.create") }}' class ='btn btn-primary'>Add students</a>
          @endif
        </td>
    </tr>
</table>

@if($students->count())
    {{ Form::open(array('name' => 'form1', 'url' => '/students')) }}
    {{ Form::hidden('semester', session('semester')) }}
    {{ Form::hidden('university', Auth::user()->university) }}

    <table class='datatable' data-sort='[["1","asc"],["2","asc"]]'>
        <thead>
            <tr>
                <th class='dataTableNoSort'>
                    <input type='checkbox' id='check_all' />
                </th>
                <th>Last name</th>
                <th>First name</th>
                <th>Gender</th>
                <th>French Univ.</th>
                <th>Email</th>
                <th>Home Institution</th>
            </tr>
        </thead>

        @foreach($students as $student)
            <tr>
                <td>
                    <input type='checkbox' name='students[]' class='check_item studentsCheckbox' value='{{ $student->id }}' onclick='setTimeout("select_action(\"form1\")",5);'/>
                    <input type='hidden' id='mail_{{ $student->id }}' value='{{ $student->mail }}' />
                    <a href='{{ asset("student") }}/{{ $student->id }}' class='studentsEdit' >
                        <img src='../img/edit.png' alt='view' border='0'/>
                    </a>
                </td>
                <td>{{ $student->lastname }}</td>
                <td>{{ $student->firstname }}</td>
                <td>{{ $student->gender }}</td>
                <td>{{ $student->univreg }}</td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->university}} @if ($student->guest) (guest) @endif</td>
            </tr>
        @endforeach

    </table>
    {{ Form::close() }}

    <br/>
    {{ Form::open(array('name' => 'form2', 'url' => '/students')) }}
        <div class='marginBottom'>
            For selected students :
            <select name='action' id='action' onchange='select_action("form1");' style='width:250px;' class='ui-widget-content ui-corner-all'>
                @foreach($options as $option)
                    <option value='{{ $option->value }}'>{{ $option->text }}</option>
                @endforeach
            </select>
            <input type='button' id='submit_button' value='Go' disabled='disabled' onclick='submit_action("form2","form1");' class='myUI-button marginLeft' />
        </div>
    {{ Form::close() }}

@endif

@endsection
