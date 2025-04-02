<!-- resources/views/cars/create.blade.php -->
<x-app-layout>
    <h1 class="text-2xl font-bold mb-6 text-blue-800">Nieuwe auto toevoegen</h1>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <form id="car-form" method="POST" action="{{ route('cars.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Progress Bar -->
            <div class="mb-6">
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div id="progress-bar" class="bg-blue-600 h-2.5 rounded-full" style="width: 0%"></div>
                </div>
                <div class="flex justify-between mt-1 text-xs text-gray-500">
                    <span>Kenteken</span>
                    <span>Details</span>
                    <span>Tags</span>
                </div>
            </div>

            <!-- Step 1: License Plate -->
            <div id="step-1" class="step">
                <div class="mb-4">
                    <label for="license_plate" class="block text-gray-700 mb-2">Kenteken</label>
                    <div class="flex">
                        <div class="flex-none bg-gray-100 border border-gray-300 rounded-l-md p-2 text-center">
                            NL
                        </div>
                        <input
                            type="text"
                            id="license_plate"
                            name="license_plate"
                            class="flex-grow border border-gray-300 rounded-r-md p-2"
                            placeholder="AA-BB-12"
                            required
                        >
                        <button
                            type="button"
                            id="fetch-details"
                            class="ml-2 bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700"
                        >
                            Go!
                        </button>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button
                        type="button"
                        id="next-step-1"
                        class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 disabled:bg-gray-400"
                        disabled
                    >
                        Volgende
                    </button>
                </div>
            </div>

            <!-- Step 2: Car Details -->
            <div id="step-2" class="step hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="brand" class="block text-gray-700 mb-2">Merk</label>
                        <input type="text" id="brand" name="brand" class="w-full border border-gray-300 rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label for="model" class="block text-gray-700 mb-2">Model</label>
                        <input type="text" id="model" name="model" class="w-full border border-gray-300 rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label for="seats" class="block text-gray-700 mb-2">Zitplaatsen</label>
                        <input type="number" id="seats" name="seats" class="w-full border border-gray-300 rounded p-2">
                    </div>

                    <div class="mb-4">
                        <label for="doors" class="block text-gray-700 mb-2">Aantal deuren</label>
                        <input type="number" id="doors" name="doors" class="w-full border border-gray-300 rounded p-2">
                    </div>

                    <div class="mb-4">
                        <label for="production_year" class="block text-gray-700 mb-2">Jaar van productie</label>
                        <input type="number" id="production_year" name="production_year" class="w-full border border-gray-300 rounded p-2">
                    </div>

                    <div class="mb-4">
                        <label for="color" class="block text-gray-700 mb-2">Kleur</label>
                        <input type="text" id="color" name="color" class="w-full border border-gray-300 rounded p-2">
                    </div>

                    <div class="mb-4">
                        <label for="mileage" class="block text-gray-700 mb-2">Kilometerstand</label>
                        <div class="flex">
                            <input type="number" id="mileage" name="mileage" class="w-full border border-gray-300 rounded-l p-2" required>
                            <span class="flex-none bg-gray-100 border border-gray-300 rounded-r-md p-2 text-center">km</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="weight" class="block text-gray-700 mb-2">Massa rijklaar</label>
                        <input type="number" id="weight" name="weight" class="w-full border border-gray-300 rounded p-2">
                    </div>

                    <div class="mb-4">
                        <label for="price" class="block text-gray-700 mb-2">Vraagprijs</label>
                        <div class="flex">
                            <span class="flex-none bg-gray-100 border border-gray-300 rounded-l-md p-2 text-center">€</span>
                            <input type="number" id="price" name="price" step="0.01" class="w-full border border-gray-300 rounded-r p-2" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="block text-gray-700 mb-2">Afbeelding (optioneel)</label>
                        <input type="file" id="image" name="image" class="w-full border border-gray-300 rounded p-2">
                    </div>
                </div>

                <div class="mt-6 flex justify-between">
                    <button
                        type="button"
                        id="prev-step-2"
                        class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600"
                    >
                        Vorige
                    </button>
                    <button
                        type="button"
                        id="next-step-2"
                        class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700"
                    >
                        Volgende
                    </button>
                </div>
            </div>

            <!-- Step 3: Tags -->
            <div id="step-3" class="step hidden">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Tags toevoegen</label>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <button type="button" class="tag-btn px-3 py-1 rounded border border-blue-300 hover:bg-blue-100">sportief</button>
                        <button type="button" class="tag-btn px-3 py-1 rounded border border-blue-300 hover:bg-blue-100">zuinig</button>
                        <button type="button" class="tag-btn px-3 py-1 rounded border border-blue-300 hover:bg-blue-100">elektrisch</button>
                        <button type="button" class="tag-btn px-3 py-1 rounded border border-blue-300 hover:bg-blue-100">gezinswagen</button>
                        <button type="button" class="tag-btn px-3 py-1 rounded border border-blue-300 hover:bg-blue-100">nieuwstaat</button>
                        <button type="button" class="tag-btn px-3 py-1 rounded border border-blue-300 hover:bg-blue-100">automaat</button>
                        <button type="button" class="tag-btn px-3 py-1 rounded border border-blue-300 hover:bg-blue-100">offroad</button>
                    </div>

                    <div id="selected-tags" class="flex flex-wrap gap-2 mb-4">
                        <!-- Selected tags will be displayed here -->
                    </div>

                    <input type="hidden" id="tags-input" name="tags">
                </div>

                <div class="mt-6 flex justify-between">
                    <button
                        type="button"
                        id="prev-step-3"
                        class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600"
                    >
                        Vorige
                    </button>
                    <button
                        type="submit"
                        class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700"
                    >
                        Aanbod afronden
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const steps = document.querySelectorAll('.step');
            const progressBar = document.getElementById('progress-bar');
            let currentStep = 1;
            let selectedTags = [];

            // License plate fetching
            document.getElementById('fetch-details').addEventListener('click', function() {
                const licensePlate = document.getElementById('license_plate').value;
                if (licensePlate) {
                    // Enable next button
                    document.getElementById('next-step-1').disabled = false;

                    // In a real application, you would fetch car details from RDW API here
                    fetch(`/api/cars/fetch-details?license_plate=${licensePlate}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Fill form fields with API data
                                document.getElementById('brand').value = data.data.brand;
                                document.getElementById('model').value = data.data.model;
                                document.getElementById('doors').value = data.data.doors;
                                document.getElementById('seats').value = data.data.seats;
                                document.getElementById('weight').value = data.data.weight;
                                document.getElementById('color').value = data.data.color;
                                document.getElementById('production_year').value = data.data.production_year;
                            } else {
                                alert(data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Er is een fout opgetreden bij het ophalen van de gegevens.');
                        });
                }
            });

            // Navigation between steps
            document.getElementById('next-step-1').addEventListener('click', function() {
                goToStep(2);
            });

            document.getElementById('prev-step-2').addEventListener('click', function() {
                goToStep(1);
            });

            document.getElementById('next-step-2').addEventListener('click', function() {
                goToStep(3);
            });

            document.getElementById('prev-step-3').addEventListener('click', function() {
                goToStep(2);
            });

            function goToStep(step) {
                steps.forEach((s, index) => {
                    if (index + 1 === step) {
                        s.classList.remove('hidden');
                    } else {
                        s.classList.add('hidden');
                    }
                });

                currentStep = step;
                updateProgressBar();
            }

            function updateProgressBar() {
                const progress = ((currentStep - 1) / (steps.length - 1)) * 100;
                progressBar.style.width = `${progress}%`;
            }

            // Tag selection
            document.querySelectorAll('.tag-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const tag = this.textContent;

                    if (selectedTags.includes(tag)) {
                        // Remove tag if already selected
                        selectedTags = selectedTags.filter(t => t !== tag);
                        this.classList.remove('bg-blue-500', 'text-white');
                    } else {
                        // Add tag if not selected
                        selectedTags.push(tag);
                        this.classList.add('bg-blue-500', 'text-white');
                    }

                    updateSelectedTags();
                });
            });

            function updateSelectedTags() {
                const container = document.getElementById('selected-tags');
                container.innerHTML = '';

                selectedTags.forEach(tag => {
                    const tagEl = document.createElement('span');
                    tagEl.textContent = tag;
                    tagEl.className = 'px-3 py-1 rounded bg-blue-500 text-white';
                    container.appendChild(tagEl);
                });

                // Update hidden input
                document.getElementById('tags-input').value = JSON.stringify(selectedTags);
            }
        });
    </script>
</x-app-layout>
