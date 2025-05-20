<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'manufacturer' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:2025',
            'horsepower' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $car = Car::create($validated);

        if ($car) {
            return redirect('/')->with('success', 'Car Successfully Created!');
        } else {
            return redirect()->back()->with('error', 'Failed to create car.');
        }
    }

    public function indexJson()
    {
        return response()->json(Car::all());
    }

    public function returnCars(Request $request)
    {
        $priceMin = $request->query('priceMin') ?? 0;
        $priceMax = $request->query('priceMax') ?? 1000000;
        $yearMin = $request->query('yearMin') ?? 1900;
        $yearMax = $request->query('yearMax') ?? 2025;
        $hpMin = $request->query('hpMin') ?? 0;
        $hpMax = $request->query('hpMax') ?? 10000;

        $carsPerPage = $request->query('carsPerPage');

        $carsToReturn = Car::orderBy($request->query('orderBy'), $request->query('sortorder'))->paginate($carsPerPage);

        $carsToReturn = Car::whereBetween('price', [$priceMin, $priceMax])
            ->whereBetween('year', [$yearMin, $yearMax])
            ->whereBetween('horsepower', [$hpMin, $hpMax])
            ->orderBy($request->query('orderBy'), $request->query('sortorder'))->paginate($carsPerPage);

        return response()->json([
            'CARS' => $carsToReturn,   // Object that contains cars to be shown
            'PAGESTOTAL' => $carsToReturn->lastPage(),   // Get total number of pages to show in HTML
            'CARSTOTAL' => $carsToReturn->total()   // Get total number of cars that match criteria
        ]);
    }

    public function deleteCars(Request $request)
    {
        $ids = $request->input("carIDs");
        Car::whereIn("id", $ids)->delete();
        return response()->json(['success' => true]);
    }
}