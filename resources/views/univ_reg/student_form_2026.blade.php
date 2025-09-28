      <tr>
        <td>
          <h2>Academic history</h2>
        </td>
      </tr>

      <tr>
        <td style='font-weight:bold;'>High school</td>
        <td>
          @if ($edit)
            <input type='text' name='question[1]' value='{{ $answer[1] }}' />
          @else
            <font class='response'>{{ $answer[1] }}</font>
          @endif
        </td>
      </tr>

      <tr>
        <td style='padding-left:30px; width:500px;'>a. High school graduation year:</td>
        <td>
          @if ($edit)
            <select name='question[2]'>
              <option value=''>&nbsp;</option>
              @for ($i = date('Y'); $i > date('Y')-30; $i--)
                <option value='{{ $i}} ' @if ($answer[2] == $i) selected='selected' @endif >{{ $i}} </option>
              @endfor
            </select>
          @else
            <font class='response'>{{ $answer[2] }}</font>
          @endif
        </td>
      </tr>

      <tr>
        <td style='padding-left:30px;'>b. Country where you attended high school:</td>
        <td>
          @if ($edit)
            <select name='question[3]'>
              <option value=''>&nbsp;</option>
              @foreach($countries as $country)
                <option value='{{ $country }}' @if ($answer[3] == $country) selected='selected' @endif >{{ $country }}</option>
              @endforeach
            </select>
          @else
            <font class='response'>{{ $answer[3] }}</font>
          @endif
        </td>
      </tr>

      <tr>
        <td style='padding-left:30px;'>c. City where you attended high school:</td>
        <td>
          @if ($edit)
            <input type='text' name='question[4]' value='{{ $answer[4] }}' />
          @else
            <font class='response'>{{ $answer[4] }}</font>
          @endif
        </td>
      </tr>

      <tr>
        <td style='padding-left:30px;'>d. State where you attended high school:</td>
        <td>
          @if ($edit)
            <select name='question[5]'>
              <option value=''>&nbsp;</option>
              @foreach ($states as $state)
                <option value='{{ $state }}' @if ($answer[5] == $state) selected='selected' @endif >{{ $state }}</option>
              @endforeach
            </select>
          @else
            <font class='response'>{{ $answer[5] }}</font>
          @endif
        </td>
      </tr>

      <tr>
        <td>&nbsp;</td>
      </tr>

      <tr>
        <td style='font-weight:bold;'>What year did you start college ?</td>
        <td>
          @if ($edit)
            <select name='question[6]'>
              <option value=''>&nbsp;</option>
              @for ($i = date('Y'); $i > date('Y') - 30; $i--){
                <option value='{{ $i }}' @if ($answer[6] == $i ) selected='selected' @endif >{{ $i }}</option>
              @endfor
            </select>
          @else
            <font class='response'>{{ $answer[6] }}</font>
          @endif
        </td>
      </tr>

      <tr>
        <td>&nbsp;</td>
      </tr>

      <tr>
        <td style='font-weight:bold;'>Your current studies:</td>
      </tr>

      <tr>
        <td>Major 1:</td>
        <td colspan='2'>
          @if ($edit)
            <input type='text' name='question[10]' value='{{ $answer[10] }}' />
          @else
            <font class='response'>{{ $answer[10] }}</font>
          @endif
        </td>
      </tr>

      <tr>
        <td>Major 2:</td>
        <td colspan='2'>
          @if ($edit)
            <input type='text' name='question[11]' value='{{ $answer[11] }}' />
          @else
            <font class='response'>{{ $answer[11] }}</font>
          @endif
        </td>
      </tr>

      <tr>
        <td>Minor / Correlate 1:</td>
        <td colspan='2'>
          @if ($edit)
            <input type='text' name='question[12]' value='{{ $answer[12] }}' />
          @else
            <font class='response'>{{ $answer[12] }}</font>
          @endif
        </td>
      </tr>

      <tr>
        <td>Minor / Correlate 2:</td>
        <td colspan='2'>
          @if ($edit)
            <input type='text' name='question[13]' value='{{ $answer[13] }}' />
          @else
            <font class='response'>{{ $answer[13] }}</font>
          @endif
        </td>
      </tr>

      <tr>
        <td>
          <h2>Accessibility accommodations</h2>
        </td>
      </tr>

      <tr>
        <td style="font-weight:bold;">Do you receive academic or other accessibility accommodations on your home campus ?</td>

        @if ($edit)
          <td style='padding-left:30px;'>
            <input type='radio' name='question[7]' value='Yes' @if ($answer[7] == 'Yes' ) checked='checked' @endif /> Yes
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td style='padding-left:30px;'>
            <input type='radio' name='question[7]' value='No' @if ($answer[7] == 'No' ) checked='checked' @endif /> No
          </td>
        @else
          <td class='response'>{{ $answer[7] }}</td>
        @endif

      </tr>

      <tr>
        <td colspan="2" style="font-weight:bold;">If so, please provide further details (type of accommodation received, etc.) ?<br/>
          Please specify if you would like to explore receiving academic accommodations while in France.</td>
      </tr>

      <tr>
        <td colspan='6'>
          @if ($edit)
            <textarea name='question[8]'>{{ $answer[8] }}</textarea>
          @else
            <font class='response'>{!! nl2br(e($answer[8])) !!}</font>
          @endif
        </td>
      </tr>

      <tr>
        <td>
          <h2>French university selection</h2>
        </td>
      </tr>

      @if (!empty($dates))
        <tr>
          <td colspan='6' style='text-align:justify;'>
            Please note that each university has a different calendar :<br/>

            @php
              $i = 4;
            @endphp

            @foreach ($partners as $partner)
	      @if ($partner->date)
                @php
                  $i++;
                @endphp

                {{ $partner->name }}, end of course <b>{{ $dates->{"date$i"} }}</b><br/>
              @endif
	    @endforeach
          </td>
        </tr>
      @endif

      <tr>
        <td colspan='6' style='padding:20px 0 0 10px; text-align:justify;'>
          <b>Please rank your choices according to preference.</b>
        </td>
      </tr>

      @php
        $i = 13;
      @endphp

      @foreach ($partners as $partner)
        @php
          $i++;
        @endphp

        <tr>
          <td>{{ $partner->name }}</td>
          <td colspan='2'>
            @if ($edit)
              <select name='question[{{ $i }}]'>
                <option value=''>&nbsp;</option>
                <option value='1st' @if ($answer[$i] == '1st') selected='selected' @endif >1st Choice</option>
                <option value='2nd' @if ($answer[$i] == '2nd') selected='selected' @endif >2nd Choice</option>
                <option value='3rd' @if ($answer[$i] == '3rd') selected='selected' @endif >3rd Choice</option>
                <option value='4th' @if ($answer[$i] == '4th') selected='selected' @endif >4th Choice</option>
                <option value='5th' @if ($answer[$i] == '5th') selected='selected' @endif >5th Choice</option>
              </select>
            @else
              <font class='response'>{{ $answer[$i] }}</font>
            @endif
          </td>
        </tr>
      @endforeach

      <tr>
        <td colspan='6' style='padding:20px 0 0 10px; text-align:justify;'>
          <b>Please provide a brief academic justification for your 1<sup>st</sup> and 2<sup>nd</sup> choices.
        </td>
      </tr>

      <tr>
        <td colspan='6'>
          @if ($edit)
            <textarea name='question[19]'>{{ $answer[19] }}</textarea>
          @else
            <font class='response'>{!! nl2br(e($answer[19])) !!}</font>
          @endif
        </td>
      </tr>

      <tr>
        <td colspan='6' style='padding:20px 0 0 10px; text-align:justify;'>
            <b>For your first choice, please specify a primary academic department (UFR) in which you plan to take most of your French university courses along with a secondary UFR where you may take courses.</b>
        </td>
      </tr>

      <tr>
        <td colspan='6'>
          @if ($edit)
              <textarea name='question[23]'>{{ $answer[23] }}</textarea>
            @else
              <font class='response'>{!! nl2br(e($answer[23])) !!}</font>
          @endif
        </td>
      </tr>

      @if (!empty($dates))
        <tr>
        <td colspan='6' style='padding:20px 0 0 10px; text-align:justify;'>
            <b>Please indicate if your choice of university is motivated by the calendar and explain your reason</b> : job, internship, graduation ...
          </td>
        </tr>
        <tr>
          <td colspan='6'>
            @if ($edit)
              <textarea name='question[22]'>{{ $answer[22] }}</textarea>
            @else
              <font class='response'>{!! nl2br(e($answer[22])) !!}</font>
            @endif
          </td>
        </tr>
      @endif

      <tr>
        <td colspan='6' style='padding:20px 0 0 10px; text-align:justify;'>
            <b>Please identify 3-5 courses that interest you in these UFRs and list their course titles below.</b>
        </td>
      </tr>

      <tr>
        <td colspan='6'>
          @if ($edit)
              <textarea name='question[24]'>{{ $answer[24] }}</textarea>
            @else
              <font class='response'>{!! nl2br(e($answer[24])) !!}</font>
          @endif
        </td>
      </tr>

      <tr>
        <td colspan='6' style='padding:40px 0 0 10px; text-align:justify;'>
          <b>The VWPP will take your preferences into account, but cannot guarantee enrollment at a certain university as placements are limited by our partners.</b>
        </td>
      </tr>

      <tr>
        <td colspan='2'>&nbsp;</td>
      </tr>

      <tr>
        <td colspan='2'>For program administration only</td>
      </tr>

      <tr>
        <td>MoveOnLine Username</td>
        <td>
          @if ($edit and Auth::user()->admin)
            <input type='text' name='question[20]' value='{{ $answer[20] }}' />
          @else
            <input type='hidden' name='question[20]' value='{{ $answer[20] }}' />
            <font class='response'>{{ $answer[20] }}</font>
          @endif
        </td>
      </tr>

      <tr>
        <td>MoveOnLine Password</td>
        <td>
          @if ($edit and Auth::user()->admin)
            <input type='text' name='question[21]' value='{{ $answer[21] }}' />
          @else
            <input type='hidden' name='question[21]' value='{{ $answer[21] }}' />
            <font class='response'>{{ $answer[21] }}</font>
          @endif
        </td>
      </tr>

      <tr>
        <td colspan='6' style='text-align:right;'>
          <br/><br/>

          @if ($edit)
            <input type='button' value='Cancel' class='btn' onclick='location.href="/univ_reg/";' />
            <input type='submit' value='Submit' class='btn btn-primary' />
          @else
            @if (Auth::user()->admin or !$university)
              <input type='button' value='Edit' class='btn btn-primary' onclick='location.href="/univ_reg/{{ $student->id }}/edit";' />
            @endif
          @endif

        </td>
      </tr>
    </table>
  </form>
</fieldset>
