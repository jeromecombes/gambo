@extends('layouts.myApp')
@section('content')

<h3>Courses</h3>

@include('courses.admin_vwpp')
@include('courses.student_form_university')
@include('tutoring.form')
@include('internship.form')

@endsection
