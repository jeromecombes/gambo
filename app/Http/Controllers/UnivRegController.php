<?php

namespace App\Http\Controllers;

use App\Models\Dates;
use App\Models\Student;
use App\Models\UnivReg;
use App\Models\UnivReg2;
use App\Models\UnivReg3;
use App\Models\UnivRegLock;
use App\Models\UnivRegShow;
use App\Helpers\CountryHelper;
use App\Helpers\StateHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session as LaravelSession;

class UnivRegController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('semester');

        $this->middleware('admin')->only('list');
        $this->middleware('role:17')->only('list');
    }

    /**
     * Display the univ registration list
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $user = auth()->user();

        $year = substr(session('semester'), -4);

        if ($user->university == 'VWPP') {
            $students = Student::where('semesters', 'like', '%"' . session('semester') .'"%')
            ->get();
        } else {
            $students = Student::where('semesters', 'like', '%"' . session('semester') .'"%')
                ->where('university', $user->university)
                ->get();
        }

        foreach ($students as $student) {
            $tab[$student->id]['student'] = $student->id;
            $tab[$student->id]['lastname'] = $student->lastname;
            $tab[$student->id]['firstname'] = $student->firstname;

            $tab[$student->id][0] = array(null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
            $tab[$student->id][1] = array(null, null, null, null, null, null, null, null, null, null, null, null);
            $tab[$student->id][2] = null;
          }

        foreach (UnivReg::where('semester', session('semester'))->get() as $elem) {
            if ($students->find($elem->student)) {
                $tab[$elem->student][0][$elem->question] = $elem->response;
            }
        }

        foreach (UnivReg2::where('semester', session('semester'))->get() as $elem) {
            if ($students->find($elem->student)) {
                $tab[$elem->student][1][$elem->question] = $elem->response;
            }
        }

        foreach (UnivReg3::where('semester', session('semester'))->get() as $elem) {
            if ($students->find($elem->student)) {
                $tab[$elem->student][2] = $elem->university;
            }
        }

        // View
        return view('univ_reg.list', compact('tab', 'year'));
    }

    /**
     * Display the univ registration form
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function student_form(Request $request)
    {

        $edit = $request->edit;

        // Get student info
        $student = Student::find(session('student'));

        // Get univ registration
        $univ_reg3 = UnivReg3::findMe();
        $university = $univ_reg3 ? $univ_reg3->university : null;

        // Check if Univ registration is locked
        $locked = UnivRegLock::findMe() ? true : false;

        // Check if Univ registration is published
        $published = UnivRegShow::findMe() ? true : false;

        // Get student form
        $univ_reg = UnivReg::getMe();

        $answer = array();
        for ($i=0; $i <= 25; $i++) {
            $answer[$i] = null;
        }
        foreach ($univ_reg as $elem) {
            $answer[$elem->question] = $elem->response;
        }

        // Get student extra form (before 2019)
        $univ_reg_plus = UnivReg2::getMe();

        $answer_plus = array();
        for ($i=0; $i <= 16; $i++) {
            $answer_plus[$i] = null;
        }
        foreach ($univ_reg_plus as $elem) {
            $answer_plus[$elem->question] = $elem->response;
        }

        // Get deadlines
        $dates = Dates::where('semester', session('semester'))->first();

        $states = StateHelper::get();
        $countries = CountryHelper::get();

        // View
        return view('univ_reg.student_form', compact('edit', 'student', 'published', 'locked', 'dates', 'university', 'answer', 'answer_plus', 'countries', 'states'));
    }

    /**
     * Update Final Univ Registration
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function univ_reg3_update(Request $request)
    {
        UnivReg3::updateOrCreate(
            array(
                'student' => session('student'),
                'semester' => session('semester'),
            ),
            array(
                'university' => $request->university,
            )
        );

        return redirect("/univ_reg")->with('success', 'Mise à jour réussie');
    }

    /**
     * Update Univ Reg
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function univ_reg_update(Request $request)
    {
        UnivReg::where('student', session('student'))
            ->where('semester', session('semester'))
            ->delete();

        foreach ($request->question as $question => $answer) {
            $univ_reg = new UnivReg();
            $univ_reg->student = session('student');
            $univ_reg->semester = session('semester');
            $univ_reg->question = $question;
            $univ_reg->response = $answer;
            $univ_reg->save();
        }

        return redirect("/univ_reg")->with('success', 'Mise à jour réussie');
    }

}
