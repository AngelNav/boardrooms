<?php

namespace App\Rules;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class CantReserveTwiceAtSameHours implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($start, $end, $id = null)
    {
        $this->id = $id;
        $this->start = Carbon::parse($start)->toDateTimeString();
        $this->end = Carbon::parse($end)->toDateTimeString();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $reservation = Reservation::where(function ($q) use ($value) {
            $q->where('boardroom_id', $value)
                ->where('active', true)
                ->orWhere(function ($q) {
                    $q->where('start_date', '>=', $this->start)
                        ->where('end_date', '<=', $this->end);
                });
        })->where('id', '!=', $this->id);

        //"select * from "reservations" where ("boardroom_id" = ? and "active" = ? or ("start_date" >= ? and "end_date" <= ?))
        // and "id" != ? and "reservations"."deleted_at" is null"
        return !$reservation->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Ya se reservó la sala para los horarios seleccionados.';
    }
}
