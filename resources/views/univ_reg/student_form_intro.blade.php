@if (substr(session('semester'), -4) >= 2026)
  <h1>French university</h1>
@else
  <h1>University Registration</h1>
@endif

<fieldset>

  @if (substr(session('semester'), -4) < 2026)
    <div style='text-align:center;margin-bottom:40px;'>
      <h3>Vassar-Wesleyan Program in Paris<br/>
        University Registration Request Form</h3>
    </div>
  @endif

  <form name='form' id='univ_reg_form' action='/univ_reg' method='post' >
    {{ csrf_field() }}
    <input type='hidden' name='student' value='{{ $student->id }}' />

    <table>
      <tr>
        <td>Last name:</td>
        <td colspan='2' class='response'>{{ $student->lastname }}</td>
      </tr>
      <tr>
        <td>First name:</td>
        <td colspan='2' class='response'>{{ $student->firstname }}</td>
      </tr>
      <tr>
        <td>Email:</td>
        <td colspan='2' class='response'>{{ $student->email }}</td>
      </tr>
