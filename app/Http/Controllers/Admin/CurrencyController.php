<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::orderBy('is_default', 'desc')->get();
        return view('backEnd.currency.index', compact('currencies'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'          => 'required|string|max:255',
                'code'          => 'required|string|max:10|unique:currencies,code',
                'symbol'        => 'required|string|max:10',
                'exchange_rate' => 'required|numeric|min:0',
                'status'        => 'required|boolean',
            ]);

            // যদি এই কারেন্সিটিকে Default সিলেক্ট করা হয়, তবে আগের Default কারেন্সিগুলোকে ০ করে দিতে হবে
            if ($request->is_default) {
                Currency::where('is_default', 1)->update(['is_default' => 0]);
            }

            Currency::create([
                'name'          => $request->name,
                'code'          => strtoupper($request->code),
                'symbol'        => $request->symbol,
                'exchange_rate' => $request->exchange_rate,
                'is_default'    => $request->is_default ?? 0,
                'status'        => $request->status,
            ]);

            return redirect()->back()->with('success', 'Currency created successfully!');
        }
        catch (\Exception $e){
            return back()->with('error', $e->getMessage());
        }

    }

    public function update(Request $request, $id)
    {
        $currency = Currency::findOrFail($id);

        $request->validate([
            'name'          => 'required|string|max:255',
            'code'          => 'required|string|max:10|unique:currencies,code,' . $id,
            'symbol'        => 'required|string|max:10',
            'exchange_rate' => 'required|numeric|min:0',
            'status'        => 'required|boolean',
        ]);

        if ($request->is_default) {
            Currency::where('is_default', 1)->update(['is_default' => 0]);
            $currency->is_default = 1;
        } else {
            // যদি অলরেডি ডিফল্ট থাকে, তবে জোরপূর্বক ০ করা যাবে না (অন্তত ১টা ডিফল্ট রাখতেই হবে)
            if ($currency->is_default) {
                return redirect()->back()->with('error', 'You must keep at least one default currency.');
            }
            $currency->is_default = 0;
        }

        $currency->update([
            'name'          => $request->name,
            'code'          => strtoupper($request->code),
            'symbol'        => $request->symbol,
            'exchange_rate' => $request->exchange_rate,
            'status'        => $request->status,
        ]);

        return redirect()->back()->with('success', 'Currency updated successfully!');
    }

    public function destroy($id)
    {
        $currency = Currency::findOrFail($id);

        if ($currency->is_default) {
            return redirect()->back()->with('error', 'Default currency cannot be deleted.');
        }

        $currency->delete();
        return redirect()->back()->with('success', 'Currency deleted permanently.');
    }
    public function switchCurrency($code)
    {
        $currency = Currency::where('code', $code)->where('status', 1)->firstOrFail();
        session(['current_currency' => $currency->code]);
        return redirect()->back();
    }
}
