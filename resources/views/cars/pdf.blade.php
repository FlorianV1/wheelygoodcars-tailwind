<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Auto: {{ $car->brand }} {{ $car->model }}</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        h1 { color: #1e40af; }
        .tags span {
            background-color: #dbeafe;
            color: #1e40af;
            padding: 4px 8px;
            margin: 2px;
            border-radius: 4px;
            display: inline-block;
            font-size: 12px;
        }
        .car-image {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
        .info {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<h1>{{ $car->brand }} {{ $car->model }}</h1>

@if($car->image)
    <img class="car-image" src="{{ public_path('storage/' . $car->image) }}" alt="Afbeelding van de auto">
@endif

<div class="info"><strong>Kenteken:</strong> {{ $car->license_plate }}</div>
<div class="info"><strong>Prijs:</strong> €{{ number_format($car->price, 2, ',', '.') }}</div>
<div class="info"><strong>KM-stand:</strong> {{ number_format($car->mileage, 0, ',', '.') }} km</div>
<div class="info"><strong>Bouwjaar:</strong> {{ $car->production_year }}</div>
<div class="info"><strong>Kleur:</strong> {{ $car->color }}</div>
<div class="info"><strong>Zitplaatsen:</strong> {{ $car->seats }}</div>
<div class="info"><strong>Deuren:</strong> {{ $car->doors }}</div>
<div class="info"><strong>Massa rijklaar:</strong> {{ $car->weight }} kg</div>

<div class="tags">
    <strong>Tags:</strong><br>
    @foreach($car->tags as $tag)
        <span>{{ $tag->name }}</span>
    @endforeach
</div>
</body>
</html>
