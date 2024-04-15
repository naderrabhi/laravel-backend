<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicianAssignment extends Model
{
    use HasFactory;

    protected $table = 'technician_assignments';

    protected $fillable = [
        'id_technician',
        'id_peripheral',
        'confirmed',
        'fixed',
        'confirmed_at',
        'fixed_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'confirmed' => 'boolean',
        'fixed' => 'boolean',
        'confirmed_at' => 'string',
        'fixed_at' => 'string',
    ];

    public function technician()
    {
        return $this->belongsTo(User::class, 'id_technician');
    }

    public function peripheral()
    {
        return $this->belongsTo(Peripheral::class, 'id_peripheral');
    }
}
