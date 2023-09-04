<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UbigeoDepartamento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Workshop extends Model
{
    use HasFactory;

    protected $table = 'workshops';

    protected $fillable = [
        'name',
        'status',
        'representante',
	    'department_id',
        'province_id',
        'district_id',
		'phone',          
        'email', 
        'last_updated_by',
        'created_by'
    ];

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function department()
    {
        return $this->belongsTo(UbigeoDepartamento::class);
    }


    public function province()
    {
        return $this->belongsTo(UbigeoProvincia::class);
    }

    public function district()
    {
        return $this->belongsTo(UbigeoDistrito::class);
    }
}
