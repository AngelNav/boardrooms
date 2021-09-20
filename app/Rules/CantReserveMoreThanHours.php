<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class CantReserveMoreThanHours implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($start)
    {
        $this->start = $start;
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
        $start = Carbon::parse($this->start);
        $end = Carbon::parse($value);
        $outOfLimit = (clone $start)->addHours(2);

        return $end <= $outOfLimit;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'No puede reservarse la sala por más de 2 horas.';
    }
}
