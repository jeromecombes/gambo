<?php

namespace App\Http\Controllers;

use App\Helpers\CourseHelper;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class GradeController extends Controller
{
    public function __construct()
    {
        App::setLocale('fr_FR');
    }

    /**
     * Edit an internship
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $edit = $request->edit;

        // Admin Read only
        $us_ro = (in_array(19, session('access')) or in_array(20, session('access')));
        // Admin update FR grades
        $fr_rw = in_array(18, session('access'));
        // Admin update US grades
        $us_rw = in_array(19, session('access'));

        // Get student courses
        $courses = CourseHelper::get();

        $default_grades = (object) array(
            'note' => null,
            'date1' => null,
            'date2' => null,
            'grade' => null,
            'grade1' => null,
            'grade2' => null,
        );

        // Grades
        $grades_tab = array('A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'D-', 'F', 'Pass', 'S', 'DS', 'W');

        $all_grades = Grade::getMe();

        $grades = array();

        foreach ($courses->local as $elem) {
            $grades['local'][$elem->id] = $all_grades->where('course', 'local')->where('course_id', $elem->id)->first() ?? $default_grades;
        }

        foreach ($courses->univ as $elem) {
            $grades['univ'][$elem->id] = $all_grades->where('course', 'univ')->where('course_id', $elem->id)->first() ?? $default_grades;
        }

        $params = compact(
            'edit',
            'fr_rw',
            'us_ro',
            'us_rw',
            'grades',
            'grades_tab',
            'courses',
        );

        // View
        return view('grades.edit', $params);
    }

    /**
     * Add or update a tutoring
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Get student courses
        $courses = $this->courses();

        foreach ($courses as $key => $value) {
            foreach ($value as $course) {
                $grade = Grade::firstOrCreate(array(
                        'semester' => session('semester'),
                        'student' => session('student'),
                        'course' => $key,
                        'course_id' => $course->id,
                    ));

                if (in_array(18, session('access'))) {
                    $grade->note = $request->{$key.'_fr_'.$course->id};
                    $grade->date1 = $request->{$key.'_fr_date_'.$course->id};
                }
                if (in_array(19, session('access'))) {
                    $grade->date2 = $request->{$key.'_us_date_'.$course->id};
                    $grade->grade = $request->{$key.'_us_'.$course->id};
                    $grade->grade1 = $request->{$key.'_us1_'.$course->id};
                    $grade->grade2 = $request->{$key.'_us2_'.$course->id};
                }
                $grade->save();
            }
        }

        return redirect()->route('grades.show')->with('success', 'Mise à jour réussie');
    }
}
