<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationCodes extends Model
{
    public $table = "verification_codes";


    protected $fillable = ['user_id', 'code', 'created_at', 'updated_at'];



}
