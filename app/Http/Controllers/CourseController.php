<?php

namespace App\Http\Controllers;

use App\Models\CourseChoice;
use App\Models\Internship;
use App\Models\RHCourse;
use App\Models\RHCourseAssignment;
use App\Models\RHCourseLock;
use App\Models\RHCoursePublish;
use App\Models\Student;
use App\Models\Tutoring;
use App\Models\UnivCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CourseController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('semester');
        $this->middleware('role:16|23');
        $this->middleware('old.session');
        $this->middleware('old.student')->except(['home', 'reidhall_assignment', 'univ_update']);
        $this->middleware('student.list')->except(['home', 'reidhall_assignment', 'univ_update']);
        $this->middleware('this.student')->only('index');

        $this->middleware('admin')->only(['home', 'local_edit', 'local_students', 'reidhall_assignment']);
        $this->middleware('role:16')->only(['local_edit', 'univ_destroy', 'univ_update']);

        App::setLocale('fr_FR');
    }

    /**
     * Display the admin home page
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function home(Request $request)
    {
        $courses = (object) array(
            'local' => RHCourse::where('semester', session('semester'))->get(),
            'univ' => UnivCourse::where('semester', session('semester'))->get(),
        );

        // View
        return view('courses.home', compact('courses'));
    }

    /**
     * Display the courses student form
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $edit = $request->edit;

        // Get student info
        $student = Student::find(session('student'));

        // VWPP Courses

        // Lock / Unlock - Publish / Hide buttons
        if (RHCourseLock::findMe()) {
            $button_lock = 'Unlock';
            $edit_vwpp = false;
        } else {
            $button_lock = 'Lock';
            $edit_vwpp = !$user->admin;
        }

        if (RHCoursePublish::findMe()) {
            $button_publish = 'Hide';
            $show_final_reg = true;
        } else {
            $button_publish = 'Publish';
            $show_final_reg = false;
        }

        // Reid Hall Courses
        $rhCourses = RHCourse::where('semester', session('semester'))->orderBy('type')->get();

        // Reid Hall Courses Assignment
        $rhCoursesAssign = RHCourseAssignment::where('semester', session('semester'))->get();

        // Count all
        $tab = array();
        foreach ($rhCoursesAssign as $elem) {
            if (!empty($elem->writing1)) $tab[] = $elem->writing1;
            if (!empty($elem->writing2)) $tab[] = $elem->writing2;
            if (!empty($elem->writing3)) $tab[] = $elem->writing3;
            if (!empty($elem->seminar1)) $tab[] = $elem->seminar1;
            if (!empty($elem->seminar2)) $tab[] = $elem->seminar2;
            if (!empty($elem->seminar3)) $tab[] = $elem->seminar3;
        }

        $count = array_count_values($tab);

        $occurences = array();
        foreach ($rhCourses as $elem) {
            $occurences[$elem->type][] = array(
                'count' => isset($count[$elem->id]) ? (int) $count[$elem->id] : 0,
                'code' => $elem->code,
                'title' => $elem->title,
                'professor' => $elem->professor,
                'type' => $elem->type
            );
        }

        if (!empty($occurences['Seminar'])) {
            usort($occurences['Seminar'], [$this, 'cmp_count_desc']);
        }

        if (!empty($occurences['Writing'])) {
            usort($occurences['Writing'], [$this, 'cmp_count_desc']);
        }

        // Student assignment IDs
        $default_assignment = (object) array(
            'writing1' => null,
            'writing2' => null,
            'seminar1' => null,
            'seminar2' => null,
            'seminar3' => null,
        );

        $assignment = $rhCoursesAssign->where('student', session('student'))->first() ?? $default_assignment;

        // Student assignment Text
        $aw1 = $assignment ? $rhCourses->find($assignment->writing1) :null;
        $aw2 = $assignment ? $rhCourses->find($assignment->writing2) :null;
        $as1 = $assignment ? $rhCourses->find($assignment->seminar1) :null;
        $as2 = $assignment ? $rhCourses->find($assignment->seminar2) :null;
        $as3 = $assignment ? $rhCourses->find($assignment->seminar3) :null;

        $assignment_text = (object) array(
            'writing1' => $aw1 ? $aw1->code . ' ' . $aw1->title . ', ' . $aw1->professor : null,
            'writing2' => $aw2 ? $aw2->code . ' ' . $aw2->title . ', ' . $aw2->professor : null,
            'seminar1' => $as1 ? $as1->code . ' ' . $as1->title . ', ' . $as1->professor : null,
            'seminar2' => $as2 ? $as2->code . ' ' . $as2->title . ', ' . $as2->professor : null,
            'seminar3' => $as3 ? $as3->code . ' ' . $as3->title . ', ' . $as3->professor : null,
        );

        // Hide final reg if no assignment (student view only)
        if ($assignment == $default_assignment) {
            $show_final_reg = false;
        }

        // Student Choices
        $choices = CourseChoice::findOrCreateMe();

        // University Courses

        // Students courses
        $courses = UnivCourse::getMe();

        // Admin with modification access
        $admin2 = in_array(16, $user->access);

        // Tutoring
        $tutoring = Tutoring::findOrCreateMe();

        // Internship
        $internship = Internship::findOrCreateMe();

        $params = compact(
            'edit',
            'edit_vwpp',
            'student',
            'assignment',
            'assignment_text',
            'button_lock',
            'button_publish',
            'choices',
            'occurences',
            'rhCourses',
            'show_final_reg',
            'courses',
            'admin2',
            'tutoring',
            'internship',
        );

        // View
        if ($user->admin) {
            return view('courses.admin', $params);
        } else {
            return view('courses.student', $params);
        }

    }

    /**
     * Reid Hall Courses Assignment
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reidhall_assignment(Request $request)
    {
        RHCourseAssignment::updateOrCreate(array(
                'student' => session('student'),
                'semester' => session('semester'),
            ),
            array(
                'writing1' => $request->writing1,
                'writing2' => $request->writing2,
                'writing3' => $request->writing3,
                'seminar1' => $request->seminar1,
                'seminar2' => $request->seminar2,
                'seminar3' => $request->seminar3,
            )
        );

        return redirect("/courses")->with('success', 'Mise à jour réussie');
    }

    /**
     * Update Reid Hall Courses Choices
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reidhall_choices(Request $request)
    {
        CourseChoice::updateOrCreate(array(
                'student' => session('student'),
                'semester' => session('semester'),
            ),
            array(
                'a1' => $request->writing1,
                'b1' => $request->writing2,
                'c1' => $request->writing3,
                'd1' => $request->writing4,
                'a2' => $request->seminar1,
                'b2' => $request->seminar2,
                'c2' => $request->seminar3,
                'd2' => $request->seminar4,
                'e2' => $request->seminar5,
            )
        );

        return redirect("/courses")->with('success', 'Mise à jour réussie');
    }

    /**
     * Edit a local course
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function local_edit(Request $request)
    {
        $user = auth()->user();

        $id = $request->id ?? 0;

        $days = array('' => '');
        for ($i = 0; $i < 7; $i++) {
            $days[$i] = jddayofweek($i, 1);
        }

        $hours = array('' => '');
        for($i =8; $i <23; $i++) {
            for($j=0; $j<60; $j = $j+15) {
                $hours[sprintf("%02d",$i).":".sprintf("%02d",$j)] = sprintf("%02d",$i)."h".sprintf("%02d",$j);
            }
        }

        $course = RHCourse::firstOrNew(['id' => $id]);

        $students = Student::where('semesters', 'like', '%"' . session('semester') .'"%')->get();

        $delete_authorized = false;

        if (in_array(16, $user->access) and $id) {
            $assignment = RHCourseAssignment::where('writing1', $id)
                ->orWhere('writing2', $id)
                ->orWhere('writing3', $id)
                ->orWhere('seminar1', $id)
                ->orWhere('seminar2', $id)
                ->first();

            if (empty($assignment)) {
                $delete_authorized = true;
            }
        }

        $delete_warning = "Etes vous sûr(e) de vouloir supprimer ce cours ?";

        if ($delete_authorized) {
            $choices = CourseChoice::where('a1', $id)
                ->orWhere('a2', $id)
                ->orWhere('b1', $id)
                ->orWhere('b2', $id)
                ->orWhere('c1', $id)
                ->orWhere('c2', $id)
                ->orWhere('d1', $id)
                ->orWhere('d2', $id)
                ->orWhere('e2', $id)
                ->get();

            if (count($choices)) {
                $tab = array();
                foreach ($choices as $elem) {
                    $tab[] = "- " . $students->find($elem->student)->displayName;
                }
                sort($tab);

                $delete_warning = "Attention, les étudiants suivants ont choisi ce cours :\\n";
                $delete_warning .= join("\\n", $tab);
            }
        }

        // View
        return view('courses.local_edit', compact('course', 'days', 'delete_authorized', 'delete_warning', 'hours'));
    }

    /**
     * Update a local course
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function local_update(Request $request)
    {
        if ($request->id) {
            $course = RHCourse::find($request->id);
        } else {
            $course = new RHCourse();
        }

        $course->code = $request->code;
        $course->professor = $request->professor;
        $course->title = $request->title;
        $course->type = $request->type;
        $course->semester = session('semester');
        $course->nom = $request->nom;
        $course->day = $request->day;
        $course->start = $request->start;
        $course->end = $request->end;
        $course->save();

        return redirect()->route('courses.home')->with('success', 'The course was added successfully.');
    }

    /**
     * Destroy a local course
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function local_destroy(Request $request)
    {
        RHCourse::destroy($request->id);

        return redirect()->route('courses.home')->with('success', 'The course was deleted successfully.');
    }

    /**
     * Show students affected to the selected course
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function local_students(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;

        // Course
        $course = RHCourse::find($id);

        // Students choices
        $choices = CourseChoice::where('a1', $id)
            ->orWhere('a2', $id)
            ->orWhere('b1', $id)
            ->orWhere('b2', $id)
            ->orWhere('c1', $id)
            ->orWhere('c2', $id)
            ->orWhere('d1', $id)
            ->orWhere('d2', $id)
            ->orWhere('e2', $id)
            ->get();

        foreach ($choices as $k => $v) {
            if ($id == $v->a1 or $id == $v->a2) {
                $choices[$k]['choice'] = "1<sup>st</sup>";
            } elseif ($id == $v->b1 or $id == $v->b2) {
                $choices[$k]['choice'] = "2<sup>nd</sup>";
            } elseif ($id == $v->c1 or $id == $v->c2) {
                $choices[$k]['choice'] = "3<sup>rd</sup>";
            } elseif ($id == $v->d1 or $id == $v->d2) {
                $choices[$k]['choice'] = "4<sup>th</sup>";
            } elseif ($id == $v->e2) {
                $choices[$k]['choice'] = "5<sup>th</sup>";
            }
        }

        // Assignment
        $assignments = RHCourseAssignment::where('writing1', $id)
            ->orWhere('writing2', $id)
            ->orWhere('writing3', $id)
            ->orWhere('seminar1', $id)
            ->orWhere('seminar2', $id)
            ->get();

        // View
        return view('courses.local_students', compact('course', 'choices', 'assignments'));
    }

    /**
     * Edit a university course
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function univ_edit(Request $request)
    {
        $user = auth()->user();

        // Admin can access the course without session('student')
        if ($user->admin and $request->id) {
            $course = UnivCourse::find($request->id);

            // All existing student courses for making links
            $courses = UnivCourse::where('semester', session('semester'))
                ->where('student', $course->student)
                ->get();
        } else {
            $courses = UnivCourse::getMe();
        }

        // Add a new course
        if (!$request->id) {
            $edit = 'edit';
            $course = new UnivCourse();

        // Edit an existing course
        } else {
            $id = $request->id;
            $edit = $request->edit;

            // The selected course
            $course = $courses->find($id);

            if (empty($course)) {
                return redirect("/courses")->with('warning', 'Access denied');
            }
        }

        // Admin with modification access
        $admin2 = in_array(16, $user->access);

        $params = compact(
            'edit',
            'courses',
            'course',
            'admin2',
        );

        // View
        return view('courses.university_form', $params);
    }

    /**
     * Add or update a university course
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function univ_update(Request $request)
    {
        $user = auth()->user();

        if ($request->id) {
            $course = UnivCourse::find($request->id);
        } else {
            $course = new UnivCourse();
            $course->student = session('student');
            $course->semester = session('semester');
        }

        // If the course is locked, students can only change modalities.
        if (!$course->lock or $user->admin) {
            $course->code = $request->code;
            $course->nom = $request->nom;
            $course->institutionAutre = $request->institutionAutre;
            $course->prof = $request->prof;
            $course->email = $request->email;
            $course->note = $request->note;
            $course->nature = $request->nature;
            $course->lien = $request->lien;
            $course->institution = $request->institution;
            $course->discipline = $request->discipline;
            $course->niveau = $request->niveau;
            $course->jour = $request->jour;
            $course->debut = $request->debut;
            $course->fin = $request->fin;
        }

        $course->modalites = $request->modalites;
        $course->modalites1 = $request->modalites1;
        if ($user->admin) {
            $course->modalites2 = $request->modalites2;
        }

        $course->save();

        if (!session('student')) {
            return redirect()->route('courses.home')->with('success', 'Mise à jour réussie');
        } else {
            return redirect()->route('courses.index')->with('success', 'Mise à jour réussie');
        }
    }

    /**
     * Destroy a university course
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function univ_destroy(Request $request)
    {
        UnivCourse::destroy($request->id);

        if (!session('student')) {
            return redirect()->route('courses.home')->with('success', 'The course was deleted successfully.');
        } else {
            return redirect()->route('courses.index')->with('success', 'Le cours a été supprimé');
        }
    }

}
