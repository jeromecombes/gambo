<nav>
  <ul class='ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all' id='student-menu' >
    @if(in_array(1, Auth::user()->access))
        <li id='li5' class='ui-state-default ui-corner-top @if (Request::is("*student*")) ui-state-active @endif'><a href='/student'>General info</a></li>
    @endif

    @if(!empty(array_intersect(array(2,7), Auth::user()->access)))
      <li id='li7' class='ui-state-default ui-corner-top @if (Request::is("*housing*")) ui-state-active @endif'><a href='/housing'>Housing</a></li>
    @endif

    @if(in_array(17, Auth::user()->access))
      <li id='li10' class='ui-state-default ui-corner-top @if (Request::is("*univ_reg*")) ui-state-active @endif'><a href='/univ_reg'>Univ. reg.</a></li>
    @endif

    @if(!empty(array_intersect(array(16,21,23), Auth::user()->access)))
      <li id='li1' class='ui-state-default ui-corner-top @if (Request::is("*courses*")) ui-state-active @endif'><a href='/courses'>Courses</a></li>
    @endif

    @if(!empty(array_intersect(array(18,19,20), Auth::user()->access)))
      <li id='li9' class='ui-state-default ui-corner-top @if (Request::is("*grades*")) ui-state-active @endif'><a href='/grades'>Grades</a></li>
    @endif

    @if(!empty(array_intersect(array(3,8), Auth::user()->access)))
      <li id='li8' class='ui-state-default ui-corner-top @if (Request::is("*documents*")) ui-state-active @endif'><a href='/documents'>Documents</a></li>
    @endif

    @if(in_array(1, Auth::user()->access))
      <li id='li4' class='ui-state-default ui-corner-top @if (Request::is("*schedule*")) ui-state-active @endif'><a href='/schedule'>Schedule</a></li>
    @endif

    @if(session('student_previous'))
      <li class='ui-state-default ui-corner-top li-previous'><a href="/{{ Request::segment(1) }}/{{session('student_previous')}}">Previous</a></li>
    @endif

    @if(session('student_next'))
      <li class='ui-state-default ui-corner-top li-next'><a href="/{{ Request::segment(1) }}/{{session('student_next')}}">Next</a></li>
    @endif

      <li  class='ui-state-default ui-corner-top back-to-list'><a href='/students'>Back to list</a></li>
  </ul>
</nav>
