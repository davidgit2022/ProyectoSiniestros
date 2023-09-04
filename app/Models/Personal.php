<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    protected $table = 'hr_per_people_f';

    protected $fillable = [   
        'first_name',
        'organization_id',
        'document_type_id',
        'document_num',
        'sex',
        'full_name',    
        'status',        
        'department_id',
        'province_id',
        'district_id',
        'phone',          
        'email', 
        'updated_at',
        'last_updated_by',
        'created_by',
    ];

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }

    public function departamento()
    {
        return $this->hasOne(UbigeoDepartamento::class, 'id', 'department_id')->withDefault();
    }

    public function provincia()
    {
        return $this->hasOne(UbigeoProvincia::class, 'id', 'province_id')->withDefault();
    }

    public function distrito()
    {
        return $this->hasOne(UbigeoDistrito::class, 'id', 'district_id')->withDefault();
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
