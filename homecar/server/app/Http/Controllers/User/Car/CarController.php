<?php

namespace App\Http\Controllers\User\Car;

use App\Http\Controllers\Controller;
use App\Models\Cars;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CarController extends Controller
{
    private $car;

    public function __construct(Cars $car)
    {
        $this->car = $car;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->car->with('brand', 'figure', 'gear', 'color', 'user')->orderBy('created_at', 'desc')->paginate(6);
        return response()->json($data, 200);
    }
    public function getCars(Request $request)
    {
        $data = $this->car->with('brand', 'figure', 'gear', 'color', 'user')->where('verify', 1)->orderBy('created_at', 'desc')->paginate(6);
        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $params = $request->all();

        $params['user_id'] = Auth::id();

        $params['slug'] = Str::slug($params['title']);

        if (isset($params['images'])) {
            $params['images'] = json_encode($params['images']);
        }

        $item = $this->car->create($params);

        return response()->json($item, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = $this->car->where('id', $id)->first();

        if (!$item) {
            return response()->json([
                'message' => 'car not found',
            ], 404);
        }

        $item['images'] = json_decode($item['images']);

        return response()->json($item, 200);
    }

    /**
     * Display the specified resource.
     */
    public function infoCar(Request $request)
    {
        $id = $request->input('id');
        $item = $this->car->where('id', $id)->with('brand', 'figure', 'gear', 'color', 'user')->first();

        if (!$item) {
            return response()->json([
                'message' => 'car not found',
            ], 404);
        }

        $item['images'] = json_decode($item['images']);

        return response()->json($item, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $params = $request->all();

        $item = $this->car->where('id', $id)->first();

        if (!$item) {
            return response()->json([
                'message' => 'car not found',
            ], 404);
        }

        $params['slug'] = Str::slug($params['title']);

        if (isset($params['images'])) {
            $params['images'] = json_encode($params['images']);
        }

        $item->update($params);

        return response()->json($item, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = $this->car->where('id', $id)->first();

        if (!$item) {
            return response()->json([
                'message' => 'car not found',
            ], 404);
        }

        $item->delete();

        return response()->json($item, 200);
    }

    public function HistorySaleCar(Request $request)
    {
        $user_id = Auth::id();

        $data = $this->car
            ->with('brand', 'figure', 'gear', 'color', 'user')
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($data, 200);
    }
}
