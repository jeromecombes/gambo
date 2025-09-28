@extends('layouts.myApp')
@section('content')

@if (substr(session('semester'), -4) >= 2026)
  @include('students.student_form_2026')
@else
  @include('students.student_form_before_2026')
@endif

@endsection
