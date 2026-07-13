<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index() {
        $countries = Country::withCount('states')->latest()->paginate(20);
        return view('backEnd.country.index', compact('countries'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|unique:countries,name',
            'code' => 'required|string|max:10|unique:countries,code',
        ]);
        Country::create($request->all());
        return back()->with('success', 'Country added successfully!');
    }

    public function update(Request $request, Country $country) {
        $request->validate([
            'name' => 'required|string|unique:countries,name,' . $country->id,
            'code' => 'required|string|max:10|unique:countries,code,' . $country->id,
            'status' => 'required|boolean'
        ]);
        $country->update($request->all());
        return back()->with('success', 'Country updated successfully!');
    }

    public function destroy(Country $country) {
        $country->delete();
        return back()->with('success', 'Country deleted successfully!');
    }
    public function getStates($id) {
        // নির্দিষ্ট দেশের সব স্টেট তুলে নিয়ে আসবে JSON আকারে
        $states = \App\Models\State::where('country_id', $id)->orderBy('name', 'asc')->get();
        return response()->json($states);
    }
    public function stateStore(Request $request) {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'names' => 'required|string', // কমা দিয়ে আলাদা করা নাম আসবে
        ]);

        $stateNames = array_map('trim', explode(',', $request->names));
        $insertedCount = 0;

        foreach ($stateNames as $name) {
            if (empty($name)) continue;
            State::firstOrCreate([
                'country_id' => $request->country_id,
                'name' => $name
            ]);
            $insertedCount++;
        }
        $totalCount = State::where('country_id', $request->country_id)->count();

        return response()->json([
            'success' => true,
            'message' => "{$insertedCount} states processed successfully!",
            'total_count' => $totalCount
        ]);
    }
    public function stateUpdate(Request $request, $id) {
        $request->validate([
            'name' => 'required|string',
        ]);

        $state = State::findOrFail($id);

        // একই দেশের অধীনে এই নাম অলরেডি আছে কিনা চেক (নিজের আইডি বাদে)
        $exists = State::where('country_id', $state->country_id)
            ->where('name', $request->name)
            ->where('id', '!=', $id)
            ->exists();

        if($exists) {
            return response()->json(['message' => 'This state name already exists in this country!'], 422);
        }

        $state->update([
            'name' => trim($request->name)
        ]);

        return response()->json(['success' => true, 'message' => 'State updated successfully!']);
    }
    public function stateDestroy($id) {
        $state = State::findOrFail($id);
        $countryId = $state->country_id;
        $state->delete();
        $totalCount = State::where('country_id', $countryId)->count();
        return response()->json(['success' => true, 'total_count' => $totalCount]);
    }
}
