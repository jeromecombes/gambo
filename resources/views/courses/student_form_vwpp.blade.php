      <tr>
        <td colspan='3'><b>Writing-Intensive Course</b></td>
        @if (in_array(16, Auth::user()->access))
          <td rowspan='11'>
            <div style='text-align:right;'>
              <input type='button' value='{{ $button_lock }}' id='lock-button' onclick='lock_local_courses();' class='btn btn-primary' />
            </div>
          </td>
        @endif
      </tr>
      <tr>
        <td style='width:250px; padding-left:30px;'>1<sup>st</sup> choice</td>
        @if ($edit_vwpp)
          <td>
            <select name='writing1'>
              <option value=''></option>
              @foreach ($rhCourses->where('type', 'Writing') as $elem)
                <option value='{{ $elem->id }}' @if ($elem->id == $choices->a1) selected='selected' @endif >{{ $elem->code }} {{ $elem->title }}, {{ $elem->professor }}</option>
              @endforeach
            </select>
          </td>
        @elseif ($choices->a1 and $rhCourses->find($choices->a1))
          <td>{{ $rhCourses->find($choices->a1)->code }} {{ $rhCourses->find($choices->a1)->title }}</td>
          <td>{{ $rhCourses->find($choices->a1)->professor }}</td>
        @endif
      </tr>
      <tr>
        <td style='padding-left:30px;'>2<sup>nd</sup> choice</td>
        @if ($edit_vwpp)
          <td>
            <select name='writing2'>
              <option value=''></option>
              @foreach ($rhCourses->where('type', 'Writing') as $elem)
                <option value='{{ $elem->id }}' @if ($elem->id == $choices->b1) selected='selected' @endif >{{ $elem->code }} {{ $elem->title }}, {{ $elem->professor }}</option>
              @endforeach
            </select>
          </td>
        @elseif ($choices->b1 and $rhCourses->find($choices->b1))
          <td>{{ $rhCourses->find($choices->b1)->code }} {{ $rhCourses->find($choices->b1)->title }}</td>
          <td>{{ $rhCourses->find($choices->b1)->professor }}</td>
        @endif
      </tr>
      <tr>
        <td style='padding-left:30px;'>3<sup>rd</sup> choice</td>
        @if ($edit_vwpp)
          <td>
            <select name='writing3'>
              <option value=''></option>
              @foreach ($rhCourses->where('type', 'Writing') as $elem)
                <option value='{{ $elem->id }}' @if ($elem->id == $choices->c1) selected='selected' @endif >{{ $elem->code }} {{ $elem->title }}, {{ $elem->professor }}</option>
              @endforeach
            </select>
          </td>
        @elseif ($choices->c1 and $rhCourses->find($choices->c1))
          <td>{{ $rhCourses->find($choices->c1)->code }} {{ $rhCourses->find($choices->c1)->title }}</td>
          <td>{{ $rhCourses->find($choices->c1)->professor }}</td>
        @endif
      </tr>
      <tr>
        <td style='padding-left:30px;'>4<sup>th</sup> choice</td>
        @if ($edit_vwpp)
          <td>
            <select name='writing4'>
              <option value=''></option>
              @foreach ($rhCourses->where('type', 'Writing') as $elem)
                <option value='{{ $elem->id }}' @if ($elem->id == $choices->d1) selected='selected' @endif >{{ $elem->code }} {{ $elem->title }}, {{ $elem->professor }}</option>
              @endforeach
            </select>
          </td>
        @elseif ($choices->d1 and $rhCourses->find($choices->d1))
          <td>{{ $rhCourses->find($choices->d1)->code }} {{ $rhCourses->find($choices->d1)->title }}</td>
          <td>{{ $rhCourses->find($choices->d1)->professor }}</td>
        @endif
      </tr>
      <tr>
        <td colspan='3'><b>Seminar</b></td>
      </tr>
      <tr>
        <td style='padding-left:30px;'>1<sup>st</sup> choice</td>
        @if ($edit_vwpp)
          <td>
            <select name='seminar1'>
              <option value=''></option>
              @foreach ($rhCourses->where('type', 'Seminar') as $elem)
                <option value='{{ $elem->id }}' @if ($elem->id == $choices->a2) selected='selected' @endif >{{ $elem->code }} {{ $elem->title }}, {{ $elem->professor }}</option>
              @endforeach
            </select>
          </td>
        @elseif ($choices->a2 and $rhCourses->find($choices->a2))
          <td>{{ $rhCourses->find($choices->a2)->code }} {{ $rhCourses->find($choices->a2)->title }}</td>
          <td>{{ $rhCourses->find($choices->a2)->professor }}</td>
        @endif
      </tr>
      <tr>
        <td style='padding-left:30px;'>2<sup>nd</sup> choice</td>
        @if ($edit_vwpp)
          <td>
            <select name='seminar2'>
              <option value=''></option>
              @foreach ($rhCourses->where('type', 'Seminar') as $elem)
                <option value='{{ $elem->id }}' @if ($elem->id == $choices->b2) selected='selected' @endif >{{ $elem->code }} {{ $elem->title }}, {{ $elem->professor }}</option>
              @endforeach
            </select>
          </td>
        @elseif ($choices->b2 and $rhCourses->find($choices->b2))
          <td>{{ $rhCourses->find($choices->b2)->code }} {{ $rhCourses->find($choices->b2)->title }}</td>
          <td>{{ $rhCourses->find($choices->b2)->professor }}</td>
        @endif
      </tr>
      <tr>
        <td style='padding-left:30px;'>3<sup>rd</sup> choice</td>
        @if ($edit_vwpp)
          <td>
            <select name='seminar3'>
              <option value=''></option>
              @foreach ($rhCourses->where('type', 'Seminar') as $elem)
                <option value='{{ $elem->id }}' @if ($elem->id == $choices->c2) selected='selected' @endif >{{ $elem->code }} {{ $elem->title }}, {{ $elem->professor }}</option>
              @endforeach
            </select>
          </td>
        @elseif ($choices->c2 and $rhCourses->find($choices->c2))
          <td>{{ $rhCourses->find($choices->c2)->code }} {{ $rhCourses->find($choices->c2)->title }}</td>
          <td>{{ $rhCourses->find($choices->c2)->professor }}</td>
        @endif
      </tr>
      <tr>
        <td style='padding-left:30px;'>4<sup>th</sup> choice</td>
        @if ($edit_vwpp)
          <td>
            <select name='seminar4'>
              <option value=''></option>
              @foreach ($rhCourses->where('type', 'Seminar') as $elem)
                <option value='{{ $elem->id }}' @if ($elem->id == $choices->d2) selected='selected' @endif >{{ $elem->code }} {{ $elem->title }}, {{ $elem->professor }}</option>
              @endforeach
            </select>
          </td>
        @elseif ($choices->d2 and $rhCourses->find($choices->d2))
          <td>{{ $rhCourses->find($choices->d2)->code }} {{ $rhCourses->find($choices->d2)->title }}</td>
          <td>{{ $rhCourses->find($choices->d2)->professor }}</td>
        @endif
      </tr>
      <tr>
        <td style='padding-left:30px;'>5<sup>th</sup> choice</td>
        @if ($edit_vwpp)
          <td>
            <select name='seminar5'>
              <option value=''></option>
              @foreach ($rhCourses->where('type', 'Seminar') as $elem)
                <option value='{{ $elem->id }}' @if ($elem->id == $choices->e2) selected='selected' @endif >{{ $elem->code }} {{ $elem->title }}, {{ $elem->professor }}</option>
              @endforeach
            </select>
          </td>
        @elseif ($choices->e2 and $rhCourses->find($choices->e2))
          <td>{{ $rhCourses->find($choices->e2)->code }} {{ $rhCourses->find($choices->e2)->title }}</td>
          <td>{{ $rhCourses->find($choices->e2)->professor }}</td>
        @endif
      </tr>
      <tr>
        <td colspan='3'><b>Ateliers</b></td>
      </tr>
      <tr>
        <td style='padding-left:30px;'>1<sup>st</sup> choice</td>
        @if ($edit_vwpp)
          <td>
            <select name='workshop1'>
              <option value=''></option>
              @foreach ($rhCourses->where('type', 'Workshop') as $elem)
                <option value='{{ $elem->id }}' @if ($elem->id == $choices->a3) selected='selected' @endif >{{ $elem->code }} {{ $elem->title }}, {{ $elem->professor }}</option>
              @endforeach
            </select>
          </td>
        @elseif ($choices->a3 and $rhCourses->find($choices->a3))
          <td>{{ $rhCourses->find($choices->a3)->code }} {{ $rhCourses->find($choices->a3)->title }}</td>
          <td>{{ $rhCourses->find($choices->a3)->professor }}</td>
        @endif
      </tr>
      <tr>
        <td style='padding-left:30px;'>2<sup>nd</sup> choice</td>
        @if ($edit_vwpp)
          <td>
            <select name='workshop2'>
              <option value=''></option>
              @foreach ($rhCourses->where('type', 'Workshop') as $elem)
                <option value='{{ $elem->id }}' @if ($elem->id == $choices->b3) selected='selected' @endif >{{ $elem->code }} {{ $elem->title }}, {{ $elem->professor }}</option>
              @endforeach
            </select>
          </td>
        @elseif ($choices->b3 and $rhCourses->find($choices->b3))
          <td>{{ $rhCourses->find($choices->b3)->code }} {{ $rhCourses->find($choices->b3)->title }}</td>
          <td>{{ $rhCourses->find($choices->b3)->professor }}</td>
        @endif
      </tr>
      <tr>
        <td style='padding-left:30px;'>3<sup>rd</sup> choice</td>
        @if ($edit_vwpp)
          <td>
            <select name='workshop3'>
              <option value=''></option>
              @foreach ($rhCourses->where('type', 'Workshop') as $elem)
                <option value='{{ $elem->id }}' @if ($elem->id == $choices->c3) selected='selected' @endif >{{ $elem->code }} {{ $elem->title }}, {{ $elem->professor }}</option>
              @endforeach
            </select>
          </td>
        @elseif ($choices->c3 and $rhCourses->find($choices->c3))
          <td>{{ $rhCourses->find($choices->c3)->code }} {{ $rhCourses->find($choices->c3)->title }}</td>
          <td>{{ $rhCourses->find($choices->c3)->professor }}</td>
        @endif
      </tr>
      <tr>
        <td style='padding-left:30px;'>4<sup>th</sup> choice</td>
        @if ($edit_vwpp)
          <td>
            <select name='workshop4'>
              <option value=''></option>
              @foreach ($rhCourses->where('type', 'Workshop') as $elem)
                <option value='{{ $elem->id }}' @if ($elem->id == $choices->d3) selected='selected' @endif >{{ $elem->code }} {{ $elem->title }}, {{ $elem->professor }}</option>
              @endforeach
            </select>
          </td>
        @elseif ($choices->d3 and $rhCourses->find($choices->d3))
          <td>{{ $rhCourses->find($choices->d3)->code }} {{ $rhCourses->find($choices->d3)->title }}</td>
          <td>{{ $rhCourses->find($choices->d3)->professor }}</td>
        @endif
      </tr>

      @if ($edit_vwpp)
        <tr>
          <td colspan='2' style='text-align:right; padding-top:30px;'>
            <input type='submit' value='Valider' class='btn btn-primary'/>
          </td>
        </tr>
      @endif

