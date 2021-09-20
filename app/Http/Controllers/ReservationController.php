<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Models\Reservation;
use Illuminate\Http\JsonResponse;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(): array
    {
        $page = request()->get("page", false);
        $limit = request()->get("limit", false);
        $orderBy = request()->get("orderBy", 'id');
        $ascending = request()->get("ascending", 1);
        $filters = json_decode(request()->get("filters", "{}"), true);
        $columns = json_decode(request()->get("columns", "[]"), true);
        $boardroom_id = request()->get("boardroomId", false);

        $appends = [];

        $purchase_orders = Reservation::where('boardroom_id', $boardroom_id);

        foreach ($filters as $filter => $value) {
            if ($value && $filter != "reload")
                switch ($filter) {
                    case 'formatted_created_at':
                    case 'formatted_updated_at':
                        $filter = $filter == 'formatted_created_at' ? 'created_at' : 'updated_at';
                        $dates = explode(" a ", $value);
                        if (count($dates) > 1)
                            $purchase_orders = $purchase_orders->whereBetween($filter, [$dates[0], $dates[1]]);
                        else
                            $purchase_orders = $purchase_orders->whereDate($filter, $dates[0]);
                        break;
                    default:
                        $purchase_orders->where($filter, 'LIKE', '%' . $value . '%');
                        break;
                }
        }

        $order = $ascending === "1" ? 'DESC' : 'ASC';
        switch ($orderBy) {
            default:
                $purchase_orders->orderBy($orderBy, $order);
                break;
        }

        $data = $purchase_orders->get();
        $count = $data->count();

        if ($limit && $page)
            $data = $data->slice(($page - 1) * $limit)->take($limit)->values();

        $data = $data->map(function ($_data) use ($columns, $appends) {
            $_data = $_data->append($appends);
            if (!isset($columns) || !empty($columns)) {
                array_push($columns, 'id');
                if (count($columns)) $_data = $_data->only($columns);
            }
            return $_data;
        });

        return compact("data", "count");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ReservationRequest $request
     * @return JsonResponse
     */
    public function store(ReservationRequest $request): JsonResponse
    {
        $reservation = Reservation::create($request->all());

        return response()->json([
            'message' => 'Reservación creada correctamente',
            'reservation' => $reservation], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Reservation $reservation
     * @return array
     */
    public function show(Reservation $reservation): array
    {
        $columns = json_decode(request()->get("columns", "[]"), true);
        array_push($columns, 'id');

        return $reservation->only($columns);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ReservationRequest $request
     * @param Reservation $reservation
     * @return JsonResponse
     */
    public function update(ReservationRequest $request, Reservation $reservation): JsonResponse
    {
        $reservation->update($request->all());
        return response()->json(['message' => "Reservación actualizada con éxito", 'reservation' => $reservation]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Reservation $reservation
     * @return JsonResponse
     */
    public function destroy(Reservation $reservation): JsonResponse
    {
        $reservation->delete();
        return response()->json(['message' => 'Reservación eliminada correctamente']);
    }
}
