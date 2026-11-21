<?php

namespace App\Models;

use App\Models\MyModel;
use Illuminate\Support\Facades\Crypt;

class Evaluation extends MyModel
{

    /**
     * @var array
     */
    protected $fillable = ['closed', 'courseId', 'form', 'question', 'semester', 'student', 'timestamp'];

    /**
     * @var array
     */
    protected $casts = [
        'response' => 'encrypted',
    ];

    // Set
    public function setResponseAttribute($value)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }

        $this->attributes['response'] = $value === null ? $value : Crypt::encryptString($value);
    }

    public function links()
    {
        return $this->hasMany(Evaluation::class, 'timestamp', 'timestamp');
    }

}
