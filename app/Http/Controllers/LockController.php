<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LockController extends Controller
{
    /**
     * Lock housing forms
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function lock(Request $request)
    {
        $students = $request->students;
        $semester = $request->session()->get('semester');

        foreach ($students as $student) {
            $model = new $this->model;
            $model->firstOrCreate(['semester' => $semester, 'student' => $student]);
        }

        return redirect('/students')->with('success', 'Update successful');
    }

    /**
     * Unlock housing forms
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function unlock(Request $request)
    {
        $students = $request->students;
        $semester = $request->session()->get('semester');

        $model = new $this->model;
        $model->where('semester', $semester)
            ->whereIn('student', $students)
            ->delete();

        return redirect('/students')->with('success', 'Update successful');
    }

    public function ajaxLocker(Request $request)
    {
        $button = $request->button;
        $model = $request->model;

        if ($request->id) {
            $model = $model::find($request->id);
        } else {
            $model = $model::findMe();
        }

        $lock = $model->lock ?? 0;
        $lock = $lock ? 0 : 1;

        if ($lock) {
            $button = strstr($button, 'Verrouiller') ? 'Déverrouiller' : 'Unlock';
        } else {
            $button = strstr($button, 'Déverrouiller') ? 'Verrouiller' : 'Lock';
        }

        $model->lock = $lock;
        $model->save();

        echo json_encode(array('error'=>false, 'button' => $button));
    }
}
