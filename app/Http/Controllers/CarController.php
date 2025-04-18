<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::with('tags')->unsold();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('brand', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%");
            });
        }

        // Tag filtering
        if ($request->has('tag')) {
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('name', $request->input('tag'));
            });
        }

        $cars = $query->paginate(30);
        $tags = Tag::withCount('cars')->orderBy('cars_count', 'desc')->get();

        return view('cars.index', compact('cars', 'tags'));
    }

    public function show(Car $car)
    {
        $car->incrementViews();
        return view('cars.show', compact('car'));
    }

    public function my()
    {
        $cars = auth()->user()->cars()->with('tags')->latest()->get();
        return view('cars.my', compact('cars'));
    }

    public function create()
    {
        return view('cars.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'license_plate' => 'required|string|unique:cars',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        // Create car with data from RDW API and form
        $car = auth()->user()->cars()->create([
            'license_plate' => $request->license_plate,
            'brand' => $request->brand,
            'model' => $request->model,
            'price' => $request->price,
            'mileage' => $request->mileage,
            'seats' => $request->seats,
            'doors' => $request->doors,
            'production_year' => $request->production_year,
            'weight' => $request->weight,
            'color' => $request->color,
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
                $path = $request->file('image')->store('cars', 'public');
                $car->update(['image' => $path]);
        }

        // Handle tags
        if ($request->filled('tags')) {
            $tagsArray = json_decode($request->input('tags'), true); // Decode JSON string to array

            $tagIds = [];
            foreach ($tagsArray as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }
            $car->tags()->sync($tagIds);
        }

        return redirect()->route('cars.my')->with('success', 'Auto succesvol toegevoegd!');
    }

    public function updateStatus(Car $car)
    {
        // Toggle sold status
        if ($car->isSold()) {
            $car->update(['sold_at' => null]);
        } else {
            $car->update(['sold_at' => now()]);
        }

        return back()->with('success', 'Status van de auto is bijgewerkt.');
    }

    public function updatePrice(Request $request, Car $car)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
        ]);

        $car->update(['price' => $request->price]);

        return back()->with('success', 'Prijs van de auto is bijgewerkt.');
    }

    public function destroy(Car $car)
    {
        $car->delete();

        return redirect()->route('cars.my')->with('success', 'Auto is verwijderd.');
    }

    public function generatePdf(Car $car)
    {
        if ($car->user_id !== auth()->id()) {
            abort(403, 'Je mag alleen je eigen auto exporteren.');
        }

        $pdf = Pdf::loadView('cars.pdf', compact('car'));

        return $pdf->download('auto-' . $car->license_plate . '.pdf');
    }

    public function fetchCarDetails(Request $request)
    {
        $licensePlate = $request->input('license_plate');

        // Replace this with actual RDW API call
        try {
            $response = Http::get("https://opendata.rdw.nl/resource/m9d7-ebf2.json?kenteken=" . strtoupper(str_replace('-', '', $licensePlate)));

            if ($response->successful() && count($response->json()) > 0) {
                $carData = $response->json()[0];

                return response()->json([
                    'success' => true,
                    'data' => [
                        'brand' => $carData['merk'] ?? '',
                        'model' => $carData['handelsbenaming'] ?? '',
                        'doors' => $carData['aantal_deuren'] ?? '',
                        'seats' => $carData['aantal_zitplaatsen'] ?? '',
                        'weight' => $carData['massa_ledig_voertuig'] ?? '',
                        'color' => $carData['eerste_kleur'] ?? '',
                        'production_year' => $carData['datum_eerste_toelating'] ? substr($carData['datum_eerste_toelating'], 0, 4) : '',
                    ]
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Geen gegevens gevonden voor dit kenteken.']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Er is een fout opgetreden bij het ophalen van de gegevens.']);
        }
    }

    public function updateTags(Request $request, Car $car)
    {
        $tagIds = [];
        foreach ($request->tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $tagIds[] = $tag->id;
        }
        $car->tags()->sync($tagIds);

        return back()->with('success', 'Tags zijn bijgewerkt.');
    }

    public function edit(Car $car)
    {
        if ($car->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('cars.edit', compact('car'));
    }

    public function update(Request $request, Car $car)
    {
        if ($car->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'price' => 'required|numeric|min:0',
            'color' => 'nullable|string|max:255',
        ]);

        $car->update($request->only(['price', 'color']));

        return redirect()->route('cars.my')->with('success', 'Auto is bijgewerkt.');
    }

    public function toggleFavorite(Car $car)
    {
        $user = auth()->user();

        if ($car->isFavoritedBy($user)) {
            $user->favorites()->detach($car);
        } else {
            $user->favorites()->attach($car);
        }

        return back();
    }

    public function buy(Car $car)
    {
        $user = auth()->user();

        if ($car->user_id === $user->id) {
            return back()->with('error', 'Je kunt je eigen auto niet kopen.');
        }

        if ($car->isSold()) {
            return back()->with('error', 'Deze auto is al verkocht.');
        }

        $car->update([
            'sold_at' => now(),
            'buyer_id' => $user->id, // optional
        ]);

        return back()->with('success', 'Je hebt deze auto succesvol gekocht!');
    }
}
