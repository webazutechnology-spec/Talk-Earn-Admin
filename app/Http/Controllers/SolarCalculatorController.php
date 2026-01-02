<?php

namespace App\Http\Controllers;

use App\Models\CalculatorState;
use App\Models\Calculation;
use App\Services\SolarCalculationService;
use Illuminate\Http\Request;

class SolarCalculatorController extends Controller
{
    protected $solarService;

    public function __construct(SolarCalculationService $solarService)
    {
        $this->solarService = $solarService;
    }

    public function calculate(Request $request)
    {
        $request->merge(['consumer_type' => $request->category]);
        $validated = $request->validate([
            'category' => 'required|in:residential,commercial,industrial',
            'monthly_bill' => 'required|numeric|min:0',
            'monthly_consumption' => 'required|numeric|min:0',
            'rooftop_area' => 'required|numeric|min:0',
            'desired_capacity' => 'required|numeric|min:0',
            'state' => 'required|exists:states,id',
            'panel_wattage' => 'required|in:330,550,600',
            'consumer_type' => 'required|in:residential,commercial,industrial',
        ]);

        $state = CalculatorState::find($validated['state']);
     
        $result = match($validated['category']) {
            'residential' => $this->solarService->calculateResidential($validated, $state),
            'commercial' => $this->solarService->calculateCommercial($validated, $state),
            'industrial' => $this->solarService->calculateIndustrial($validated, $state),
        };

        return response()->json($result);
    }

    public function saveCalculation(Request $request)
    {
        $calculation = Calculation::create([
            'category' => $request->category,
            'monthly_consumption' => $request->monthly_consumption,
            'system_capacity' => $request->system_capacity,
            'installation_cost' => $request->installation_cost,
            'monthly_savings' => $request->monthly_savings,
            'payback_period' => $request->payback_period,
            'state_id' => $request->state_id,
            'ip_address' => $request->ip(),
        ]);

        return response()->json(['success' => true, 'id' => $calculation->id]);
    }
}
