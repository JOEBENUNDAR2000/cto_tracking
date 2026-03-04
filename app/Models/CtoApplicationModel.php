<?php

namespace App\Models;

use CodeIgniter\Model;

class CtoApplicationModel extends Model
{
    protected $table = 'cto_applications';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'month',
    'employee_name',
    'division',
    'employment_type',
    'date_filing',
    'inclusive_date',
    'total_earned_hours',
    'total_used_hours',
    'remaining_coc',
    'remarks'
    ];
}