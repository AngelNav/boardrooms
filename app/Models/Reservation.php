<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'reservations';

    /**
     * Fillable fields for current table.
     *
     * @var string
     */
    protected $fillable = [
        'boardroom_id', 'start_date', 'end_date', 'active'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'datetime:Y-m-d H:i',
        'end_date' => 'datetime:Y-m-d H:i',
        'active' => 'boolean'
    ];

    /**
     * @return BelongsTo
     */
    public function boardroom(): BelongsTo
    {
        return $this->belongsTo(Boardroom::class);
    }
}
