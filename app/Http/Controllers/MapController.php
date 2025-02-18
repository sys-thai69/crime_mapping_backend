<?php

namespace App\Http\Controllers;

use App\Models\Crime;
use App\Models\CrimeType;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function mappage()
    {
        $mapId = 'myMapId';
        $centerPoint = ['lat' => 40.7128, 'long' => -74.0060];
        $zoomLevel = 10;
        $mapType = 'roadmap';
        $markers = [
            ['lat' => 40.7128, 'long' => -74.0060, 'title' => 'Marker 1'],
        ];
        $fitToBounds = true;
        $centerToBoundsCenter = false;
        $attributes = ['style' => 'height: 500px;', 'class' => 'map-class'];

        return view('guest/mappage', compact('mapId', 'centerPoint', 'zoomLevel', 'mapType', 'markers', 'fitToBounds', 'centerToBoundsCenter', 'attributes'));
    }

    public function getCrimeData()
    {
        $crimeTypes = CrimeType::all();
        $crimes = Crime::all();
        return response()->json($crimes);
    }
}
