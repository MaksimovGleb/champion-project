<?php

namespace App\Models;

use App\Models\Payment\Plan;
use App\Traits\ForHumans;
use App\Traits\simpleCRUD;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateUser extends Model
{
    use HasFactory;
    use simpleCRUD;
    use ForHumans;

    protected $fillable = [
        'cert_id', 'user_id', 'saler_id',
    ];

    protected $table = 'certificate_user';

    public function cert()
    {
        return $this->belongsTo(Plan::class, 'cert_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function saler()
    {
        return $this->belongsTo(Saler::class, 'saler_id');
    }
}
