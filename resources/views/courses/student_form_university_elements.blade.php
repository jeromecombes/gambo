    @if ($course->linkedTo)
      <div style='position:absolute;font-size:40pt;'>&rdsh;</div>
      @php
        $disabled = "disabled='disabled'";
        $margin1 = 50;
        $margin2 = 0;
      @endphp
    @else
      @php
        $disabled = null;
        $margin1 = 0;
        $margin2 = 50;
      @endphp
    @endif


    @php
      // Modalities can be edited even if the course is locked.
      $edit_modalities = $edit;

      // Admin with modification access can edit even if the course is locked.
      if ($course->lock and !$admin2) {
          $edit = false;
      }

    @endphp


    <fieldset style='margin-left:{{ $margin1 }}px;'>

      <form name='univ_course_{{ $course->id }}' method='post' action='/courses/univ'>
        <input type='hidden' name='id' value='{{ $course->id }}' />

        {{ csrf_field() }}

        <table style='margin-left:{{ $margin2 }}px;' class='tableUnivCourse' >

          <tr>
            <td>Code</td>
            <td class='response'>
              @if ($edit)
                <input type='text' name='code' value='{{ $course->code }}'/>
              @else
                {{ $course->code }}
              @endif
            </td>
          </tr>

          <tr>
            <td>Nom du cours</td>
            <td class='response'>
              @if ($edit)
                <input type='text' name='nom' value='{{ $course->nom }}'/>
              @else
                {{ $course->nom }}
              @endif
            </td>
          </tr>

          <tr>
            <td>Nature du cours</td>
            <td class='response'>
              @if ($edit)
                <select name='nature'>
                  <option value=''>&nbsp;</option>
                  @foreach (explode(',', env('APP_COURSE_TYPE')) as $elem)
                    <option value='{{ $elem }}' @if ($course->nature == $elem) selected='selected' @endif >{{ $elem }}</option>
                  @endforeach
                </select>
              @else
                {{ $course->nature }}
              @endif
            </td>
          </tr>

          {{-- EDIT Course link --}}

          @if ($edit)
            @if (count($courses->where('lien', null)) and !count($course->links))
              <tr>
                <td style='padding-top:20px;'>
                  Si ce cours est rattaché à un autre cours déjà enregistré,<br/>veuillez le sélectionner dans cette liste
                </td>
                <td style='padding-top:20px;'>
                  <select name='lien' onchange='checkLink(this, {{ Auth::user()->admin }}, {{ $course->id }});'>
                    <option value=''>&nbsp;</option>
                    @foreach ($courses->where('lien', null) as $elem)
                        <option value='{{ $elem->id }}' @if ($course->lien == $elem->id) selected='selected' @endif >{{ $elem->nom }}, {{$elem->prof }} ({{$elem->nature }})</option>
                    @endforeach
                  </select>
                </td>
              </tr>
            @endif

            <tr>
              <td style='padding-top:20px;'>Institution</td>
              <td style='padding-top:20px;'>
                <select name='institution' id='institution{{ $course->id }}' onchange='checkInstitution(this, {{ $course->id }});' {{ $disabled }}>
                  <option value=''>&nbsp;</option>
                  @foreach (explode(',', env('APP_INSTITUTIONS')) as $elem)
                    <option value='{{ $elem }}' @if ($course->institution == $elem) selected='selected' @endif >{{ $elem }}</option>
                  @endforeach
                  <option value='Autre' @if ($course->institution == 'Autre') selected='selected' @endif >Autre (Précisez)</option>
                </select>
              </td>
            </tr>

            <tr id='institutionAutreTr{{ $course->id }}' @if ($course->institution != 'Autre') style='display:none;' @endif>
              <td>Autre institution</td>
              <td>
                <input type='text' name='institutionAutre' id='institutionAutre{{ $course->id }}' value='{{ $course['institutionAutre'] }}' {{ $disabled}} />
              </td>
            </tr>

            <tr>
              <td>Discipline</td>
              <td>
                <select name='discipline' {{ $disabled }} id='discipline{{ $course->id }}'>
                  <option value=''>&nbsp;</option>
                  @foreach (explode(',', env('APP_DISCIPLINES')) as $elem)
	                  <option value='{{ $elem }}' @if ($course->discipline == $elem) selected='selected' @endif >{{ $elem }}</option>
                  @endforeach
                </select>
              </td>
            </tr>

            <tr>
              <td>Niveau</td>
              <td>
                <select name='niveau' {{ $disabled }} id='niveau{{ $course->id }}'>
                  <option value=''>&nbsp;</option>
                  @foreach (explode(',', env('APP_LEVELS')) as $elem)
                    <option value='{{ $elem }}' @if ($course->niveau == $elem) selected='selected' @endif >{{ $elem }}</option>
                  @endforeach
                </select>
              </td>
            </tr>

          {{-- END EDIT Course link --}}

          @else

          {{-- SHOW Course link --}}

            @if ($course->linkedTo)
              <tr>
                <td style='padding-top:20px;'>Ce cours est rattaché au cours suivant :</td>
                <td style='padding-top:20px;' class='response'>{{ $course->linkedTo->nom }}, {{ $course->linkedTo->prof }} ({{ $course->linkedTo->nature }})</td>
              </tr>
            @else
              <tr>
                <td style='padding-top:20px;'>Institution</td>
                <td style='padding-top:20px;' class='response'> {{$course->institution }}</td>
              </tr>

              <tr>
                <td>Discipline</td>
                <td class='response'>{{ $course->discipline }}</td>
              </tr>

              <tr>
                <td>Niveau</td>
                <td class='response'>{{ $course->niveau }}</td>
              </tr>
            @endif
          @endif

          {{-- END SHOW Course link --}}

          <tr>
            <td style='padding-top:20px;'>Professeur (Nom, Prénom)</td>
            <td style='padding-top:20px;' class='response'>
              @if ($edit)
                <input type='text' name='prof' value='{{ $course->prof }}' />
              @else
                {{ $course->prof }}
              @endif
            </td>
          </tr>

          <tr>
            <td>E-mail</td>
            <td class='response'>
              @if ($edit)
                <input type='text' name='email' value='{{ $course->email }}' />
              @else
                {{ $course->email }}
              @endif
            </td>
          </tr>

          <tr>
            <td>Horaires</td>
            <td class='response'>
              @if ($edit)
                <select name='jour' style='width:31%;'>
                  <option value=''>Jour</option>
                  @for ($i = 0; $i < 7; $i++)
                    <option value='{{ $i + 1 }}' @if ($course->jour == $i + 1) selected='selected' @endif >{{ __(jddayofweek($i, 1)) }}</option>
                  @endfor
                </select>
                <select name='debut' style='width:33%;'>
                  <option value=''>Début</option>
                  @for ($i = 8; $i < 22; $i++)
                    @for ($j = 0; $j < 60; $j = $j + 15)
                      @php
                        $h1 = sprintf("%02d",$i) . ':' . sprintf("%02d",$j);
                        $h2 = sprintf("%02d",$i) . 'h'. sprintf("%02d",$j);
                      @endphp
                      <option value='{{ $h1 }}' @if ($course->debut == $h1) selected='selected'@endif >de {{ $h2 }}</option>
                    @endfor
                  @endfor
                </select>

                <select name='fin' style='width:33%;'>
                  <option value=''>Fin</option>
                  @for ($i = 8; $i < 22; $i++)
                    @for ($j = 0; $j < 60; $j = $j + 15)
                      @php
                        $h1 = sprintf("%02d",$i) . ':' . sprintf("%02d",$j);
                        $h2 = sprintf("%02d",$i) . 'h'. sprintf("%02d",$j);
                      @endphp
                      <option value='{{ $h1 }}' @if ($course->fin == $h1) selected='selected'@endif >de {{ $h2 }}</option>
                    @endfor
                  @endfor
                </select>
              @else
                @if (is_numeric($course->jour)) {{ __(jddayofweek($course->jour-1, 1)) }} @endif {{ $course->debut }} {{ $course->fin }}
              @endif
              </td>
          </tr>

          <tr>
            <td style='padding-top:20px;'>Aurez-vous une note pour ce cours ?</td>
            <td style='padding-top:20px;' class='response'>
              @if ($edit)
                <input type='radio' name='note' id='grade_yes' value='Yes' @if ($course->note == 'Yes') checked='checked' @endif /> <label for='grade_yes' >Oui</label>
                <input type='radio' name='note' id='grade_no' value='No' @if ($course->note == 'No') checked='checked' @endif /> <label for='grade_no' >Non</label>
              @else
                {{ __($course->note) }}
              @endif
            </td>
          </tr>

          <tr>
            <td colspan='2' style='padding-top:20px;'>Avez-vous discuté des modalités du devoir final avec votre professeur ?</td>
          </tr>

          <tr id='modalites0_{{ $course->id }}'>
            <td>&nbsp;</td>
            <td class='response'>
              @if ($edit_modalities)
                <input type='radio' name='modalites' id='modalities_yes' value='Yes' @if ($course->modalites == 'Yes') checked='checked' @endif /> <label for='modalities_yes' >Oui</label>
                <input type='radio' name='modalites' id='modalities_no' value='No' @if ($course->modalites == 'No') checked='checked' @endif /> <label for='modalities_no' >Non</label>
              @else
                {{ __($course->modalites) }}
              @endif
              </td>
          </tr>

          <tr>
            <td colspan='2'>Si oui, quelles sont-elles ?</td>
          </tr>

          <tr id='modalitesText{{ $course->id }}'>
            <td colspan='2' class='response'>
              @if ($edit_modalities)
                <textarea name='modalites1'>{{ $course->modalites1 }}</textarea>
              @else
                {!! nl2br(e($course->modalites1)) !!}
              @endif
              </td>
          </tr>

          <tr>
            <td colspan='2' style='font-size:9pt;'>Champ réservé aux administrateurs</td>
          </tr>
          <tr>
            <td colspan='2' class='response'>
              @if (Auth::user()->admin and $edit_modalities)
                <textarea name='modalites2'>{{ $course->modalites2 }}</textarea>
              @else
                {!! nl2br(e($course->modalites2)) !!}
              @endif
            </td>
          </tr>

          @if ($edit_modalities)
            <tr>
              <td colspan='2' style='text-align:right;'>
                @if (session('student'))
                  <input type='button' value='Annuler' onclick='document.location.href="{{ asset('courses') }}";' class='btn'/>
                @else
                  <input type='button' value='Annuler' onclick='document.location.href="{{ route('courses.home') }}";' class='btn'/>
                @endif
                <input type='submit' value='Valider' class='btn btn-primary' />
              </td>
            </tr>
          @else
            <tr>
              <td colspan='2' style='padding-top:20px; text-align:right;'>
                @if (!session('student'))
                  <input type='button' value='Annuler' onclick='document.location.href="{{ route('courses.home') }}";' class='btn'/>
                @endif

                @if (($admin2 or (!Auth::user()->admin and !$course->lock)) and !count($course->links))
                  <input type='button' value='Supprimer' onclick='delete_univ_course({{ $course->id }});' class='btn'/>
                @endif

                @if ($admin2 or !Auth::user()->admin)
                  <input type='button' value='Modifier' onclick='document.location.href="{{ asset('course/univ/') }}/{{ $course->id }}/edit";' class='btn btn-primary' />
                @endif

                @if ($admin2)
                  <input type='button' value='@if ($course->lock) Déverrouiller @else Verrouiller @endif' id='lock{{ $course->id }}' onclick='lockCourse4({{ $course->id }});' class='btn btn-primary'/>
                @endif
              </td>
            </tr>
          @endif
        </table>
      </form>
    </fieldset>

    @if (!session('student') and $admin2 and !count($course->links))
      {!! Form::open(['route' => 'courses.univ.delete', 'id' => 'delete-univ']) !!}
      {!! Form::hidden('_method', 'DELETE') !!}
      {!! Form::hidden('id', '', ['id' => 'delete-univ-id']) !!}
      {!! Form::close() !!}
    @endif
