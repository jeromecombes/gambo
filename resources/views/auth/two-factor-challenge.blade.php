@extends('auth.layouts')
@section('content')

  <p id='login_info'>Please provide your 6 digits two factor authenfication code</p>

  <form class="form-horizontal" method='POST' action='/two-factor-challenge'>
    {{ csrf_field() }}

    <div class="form-group">
      <label for="code" class="col-md-4 control-label">6 digits code</label>

      <div class="col-md-6">
        <input id="code" type="text" class="form-control" name="code" required autofocus autocomplete='off' />
      </div>
    </div>

    <div class="form-group" style="margin-top: 40px;">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">
                Login
            </button>
        </div>
    </div>

  </form>

@endsection
