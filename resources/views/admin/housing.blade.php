@extends('layouts.myApp')
@section('content')

<h3>Housing</h3>

<p>
    <a href="{{ asset('admin/housing-list.php') }}">Liste des logements</a>
</p>
<p>
    <a href="{{ asset('admin/housing-request.php') }}">Demande des étudiants</a>
</p>

@endsection