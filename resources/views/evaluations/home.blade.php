@extends('layouts.myApp')
@section('content')

  <h3>Evaluation Forms {{ session('semester') }} </h3>

  <div class='align-right'>
    {{ Form::open(['route' => 'evaluations.enable']) }}
      <input type='button' id='evaluations_enable' value='@if ($evaluations_enabled) Disable evaluations @else Enable evaluations @endif' class='btn btn-primary' />
    {{ Form::close() }}
  </div>

  <fieldset id='evaluations_home_fieldset'>

    <h4>Program Evaluations</h4>
    <ul>
      <li><a href='{{ route("evaluations.table", "program") }}'>Table</a></li>
      <li><a href='{{ route("evaluations.list", "program") }}'>Individual evaluations</a></li>
    </ul>

    <h4>VWPP Courses Evaluations</h4>
    <ul>
      <li><a href='{{ route("evaluations.table", "local") }}'>Table</a></li>
      <li><a href='{{ route("evaluations.list", "local") }}'>Individual evaluations</a></li>
    </ul>

    <h4>University Courses Evaluation</h4>
    <ul>
      <li><a href='{{ route("evaluations.table", "univ") }}'>Table</a></li>
      <li><a href='{{ route("evaluations.list", "univ") }}'>Individual evaluations</a></li>
    </ul>

    <h4>Tutoring Evaluations</h4>
    <ul>
      <li><a href='{{ route("evaluations.table", "tutoring") }}'>Table</a></li>
      <li><a href='{{ route("evaluations.list", "tutoring") }}'>Individual evaluations</a></li>
    </ul>

    <h4>Ateliers Linguistiques</h4>
    <ul>
      <li><a href='{{ route("evaluations.table", "linguistic") }}'>Table</a></li>
      <li><a href='{{ route("evaluations.list", "linguistic") }}'>Individual evaluations</a></li>
    </ul>

    <h4>Ateliers Méthodologiques</h4>
    <ul>
      <li><a href='{{ route("evaluations.table", "method") }}'>Table</a></li>
      <li><a href='{{ route("evaluations.list", "method") }}'>Individual evaluations</a></li>
    </ul>

    <h4>Internship Evaluations</h4>
    <ul>
      <li><a href='{{ route("evaluations.table", "internship") }}'>Table</a></li>
      <li><a href='{{ route("evaluations.list", "internship") }}'>Individual evaluations</a></li>
    </ul>
  </fieldset>

@endsection
