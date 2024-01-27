@extends('layouts.myApp')
@section('content')

<h3>Home Page</h3>
<p>
Welcome to the Administrative Database for the Vassar-Wesleyan Program in Paris!<br/><br/>
Please choose the semester to which you would like to add students. You can also consult or edit a previously created list.<br/><br/>
By clicking on the appropriate tab at the top, you can add or edit information regarding students, courses, grades, housing, evaluations or users for the semester chosen.<br/><br/>
</p>

{{ Html::form('POST', '/admin/semester')->open() }}

    <table>
        <tr>
            <td style='width:30%; white-space:nowrap;'>{{ Html::label('semester', 'Select a semester')->class(['col-md-4', 'control-label']) }}</td>
            <td style='width:30%;'>{{ Html::select('semester', $semesters, $semester)->class(['form-control']) }}</td>
            <td style='width:30%;'>{{ Html::submit('OK')->class(['btn', 'btn-primary']) }}</td>
        </tr>
    </table>

{{ Html::form()->close() }}

@endsection
