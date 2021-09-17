<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoardroomRequest;
use App\Models\Boardroom;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BoardroomController extends Controller
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

        $appends = [];

        $purchase_orders = Boardroom::query();

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
            case 'formatted_created_at':
            case 'formatted_updated_at':
                $orderBy = $orderBy === 'formatted_created_at' ? 'created_at' : 'updated_at';
                $purchase_orders->orderBy($orderBy, $order);
                break;
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
     * @param BoardroomRequest $request
     * @return JsonResponse
     */
    public function store(BoardroomRequest $request): JsonResponse
    {
        $boardroom = Boardroom::create($request->all());

        return response()->json(['success' => true, 'boardroom' => $boardroom], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Boardroom $boardroom
     * @return Response
     */
    public
    function show(Boardroom $boardroom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\Models\Boardroom $boardroom
     * @return Response
     */
    public
    function update(Request $request, Boardroom $boardroom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Boardroom $boardroom
     * @return Response
     */
    public
    function destroy(Boardroom $boardroom)
    {
        //
    }
}
