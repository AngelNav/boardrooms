<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Boardroom extends Model
{
    use HasFactory, softDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'boardrooms';

    /**
     * Fillable fields for current table.
     *
     * @var string
     */
    protected $fillable = ['name'];
}
