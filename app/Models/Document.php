<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /**
     * @var array
     */
    protected $casts = [
        'firstname' => 'encrypted',
        'lastname' => 'encrypted',
    ];

    public $timestamps = false;

    public function getNameAttribute($value)
    {
        return decrypt($value);
    }

    public function getPathAttribute()
    {
        return date('Y/m/', $this->timestamp).$this->id;
    }

    public function getRealnameAttribute($value)
    {
        return decrypt($value);
    }

    public function getSizeAttribute($value)
    {
        $value = decrypt($value);
        
        $ko = $value / 1024;
        $mo = $ko /1024;
        $go = $mo /1024;
        
        if ($go > 1 ) {
            $value = number_format($go, 2).' GB';
        }  elseif ($mo > 1 ) {
            $value = number_format($mo, 2).' MB';
        } elseif ($ko > 1 ) {
            $value = number_format($ko, 2).' KB';
        } else {
            $value = number_format($value, 2).' B';
        }

        return $value;
    }

    public function getTimeAttribute($value)
    {
        return date(getenv('DATE_FORMAT'), $this->timestamp);
    }

    public function getTypeAttribute($value)
    {
        return decrypt($value);
    }

    public function getType2Attribute($value)
    {
        return decrypt($value);
    }

    public function getVisibilityAttribute()
    {
        return $this->adminOnly ? "Admin Only" : null;
    }

    public function scopeWithStudents($query)
    {
        $query->leftjoin('students', 'students.id', '=', 'documents.student')
            ->addSelect('students.lastname', 'students.firstname');
    }

}
