<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class MyModel extends Model
{

    protected function getMe()
    {
        $object = $this::where('student', session('student'))
            ->where('semester', session('semester'))
            ->orderBy('created_at','asc')
            ->get();

        return $object;
    }

    protected function findMe()
    {
        $object = $this::where('student', session('student'))
            ->where('semester', session('semester'))
            ->first();

        return $object;
    }

    protected function findOrCreateMe()
    {
        $object = $this::firstOrNew([
            'student' => session('student'),
            'semester' => session('semester'),
        ]);

        return $object;
    }

    public function getDayTextAttribute()
    {
        if (isset($this->day) and is_numeric($this->day)) {
            return jddayofweek($this->day, 1);
        }

        return null;
    }

}
