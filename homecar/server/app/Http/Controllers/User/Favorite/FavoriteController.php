<?php

namespace App\Http\Controllers\User\Favorite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorites;

class FavoriteController extends Controller
{
    private $favorites;

    public function __construct(favorites $favorites)
    {
        $this->favorites = $favorites;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = auth()->id(); 

        $data = $this->favorites
            ->with(['user', 'car.brand','car.figure', 'car.gear', 'car.color']) 
            ->where('user_id', $user_id) 
            ->orderBy('created_at', 'desc') 
            ->get(); 
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
        // Check if already favorited to prevent duplicates
        $existingFavorite = Favorites::where('user_id', auth()->id())
        ->where('car_id', $request->car_id)
        ->first();
    
        if ($existingFavorite) {
            return response()->json(['message' => 'Vehicle is already in favorites'], 409);
        }
    
        // Create favorite record
        $favorite = Favorites::create([
            'user_id' => auth()->id(),
            'car_id' => $request->car_id,
        ]);
    
        return response()->json($favorite, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = $this->favorites->where('id', $id)->first();

        if (!$item) {
            return response()->json([
                'message' => 'car not found',
            ], 404);
        }

        $item->delete();

        return response()->json($item, 200);
    }
}
