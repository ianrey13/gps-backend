<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Events\LocationUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'accuracy' => 'nullable|numeric',
            'speed' => 'nullable|numeric',
            'battery_level' => 'nullable|integer|between:0,100'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $location = Location::create([
            'device_id' => $request->device_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'accuracy' => $request->accuracy,
            'speed' => $request->speed,
            'battery_level' => $request->battery_level,
            'timestamp' => now()
        ]);

        broadcast(new LocationUpdated($location));

        return response()->json([
            'success' => true,
            'message' => 'Location saved successfully',
            'data' => $location
        ], 201);
    }

    public function index(Request $request)
    {
        $deviceId = $request->get('device_id');
        $limit = $request->get('limit', 100);
        
        $query = Location::query();
        
        if ($deviceId) {
            $query->where('device_id', $deviceId);
        }
        
        $locations = $query->orderBy('timestamp', 'desc')
                          ->limit($limit)
                          ->get();
        
        return response()->json([
            'success' => true,
            'data' => $locations
        ]);
    }

    public function latest(Request $request)
    {
        $deviceId = $request->get('device_id');
        
        $query = Location::query();
        
        if ($deviceId) {
            $query->where('device_id', $deviceId);
        }
        
        $latest = $query->orderBy('timestamp', 'desc')->first();
        
        return response()->json([
            'success' => true,
            'data' => $latest
        ]);
    }

    public function devices()
    {
        $devices = Location::select('device_id')
                          ->distinct()
                          ->get()
                          ->pluck('device_id');
        
        return response()->json([
            'success' => true,
            'data' => $devices
        ]);
    }
}