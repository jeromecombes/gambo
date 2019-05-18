<nav>
    <ul class='ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all' id='student-menu' >
            <li id='li5' class='ui-state-default ui-corner-top'><a href='/admin/students-view2.php?menu_id=1'>General info</a></li>

        @if(in_array(2, session('access')))
            <li id='li7' class='ui-state-default ui-corner-top'><a href='/admin/students-view2.php?menu_id=2'>Housing</a></li>
        @endif

        @if(in_array(17, session('access')))
            <li id='li10' class='ui-state-default ui-corner-top'><a href='/admin/students-view2.php?menu_id=5'>Univ. reg.</a></li>
        @endif

        @if(in_array(23, session('access')))
            <li id='li1' class='ui-state-default ui-corner-top'><a href='/admin/students-view2.php?menu_id=4'>Courses</a></li>
        @endif

        @if(!empty(array_intersect(array(18,19,20), session('access'))))
            <li id='li9' class='ui-state-default ui-corner-top'><a href='/admin/students-view2.php?menu_id=7'>Grades</a></li>
        @endif

        @if(in_array(3, session('access')))
            <li id='li8' class='ui-state-default ui-corner-top ui-state-active'><a href='/documents'>Documents</a></li>
        @endif

            <li id='li4' class='ui-state-default ui-corner-top'><a href='/admin/students-view2.php?menu_id=8'>Schedule</a></li>
        
        @if(session('student_previous'))
            <li class='ui-state-default ui-corner-top li-previous'><a href="/documents/{{session('student_previous')}}">Previous</a></li>
        @endif

        @if(session('student_next'))
            <li class='ui-state-default ui-corner-top li-next'><a href="/documents/{{session('student_next')}}">Next</a></li>
        @endif

            <li  class='ui-state-default ui-corner-top back-to-list'><a href='/admin/students-list.php'>Back to list</a></li>
    </ul>
</nav>