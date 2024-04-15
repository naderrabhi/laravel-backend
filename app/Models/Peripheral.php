<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peripheral extends Model
{
    use HasFactory;

    protected $table = 'peripherals';

    protected $fillable = [
        'name',
        'type',
        'description',
        'status',
        'id_reporteduser'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_reporteduser');
    }

    public function technicianAssignments()
    {
        return $this->hasMany(TechnicianAssignment::class, 'id_peripheral');
    }
}
