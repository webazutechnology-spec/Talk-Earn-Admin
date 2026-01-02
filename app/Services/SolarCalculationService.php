<?php

namespace App\Services;

class SolarCalculationService
{
    private const AREA_PER_KW = 100; // sq ft
    
    private const PANEL_AREA = [
        330 => 20.86,
        550 => 35.5,
        600 => 38.5,
    ];

    private const ANNUAL_EFFICIENCY_LOSS = 0.15; // 15% degradation/loss

    public function getStateList(){
        return collect([
            ['name' => 'Andhra Pradesh', 'solar_irradiance' => 5.2, 'average_rate_per_unit' => 7.5],
            ['name' => 'Karnataka', 'solar_irradiance' => 5.0, 'average_rate_per_unit' => 7.2],
            ['name' => 'Maharashtra', 'solar_irradiance' => 5.1, 'average_rate_per_unit' => 8.0],
            ['name' => 'Tamil Nadu', 'solar_irradiance' => 5.3, 'average_rate_per_unit' => 7.8],
            ['name' => 'Rajasthan', 'solar_irradiance' => 5.4, 'average_rate_per_unit' => 7.0],
            ['name' => 'Delhi', 'solar_irradiance' => 4.5, 'average_rate_per_unit' => 8.5],
            ['name' => 'Punjab', 'solar_irradiance' => 4.2, 'average_rate_per_unit' => 7.5],
            ['name' => 'Gujarat', 'solar_irradiance' => 5.3, 'average_rate_per_unit' => 7.3],
            ['name' => 'Madhya Pradesh', 'solar_irradiance' => 5.0, 'average_rate_per_unit' => 6.8],
            ['name' => 'Telangana', 'solar_irradiance' => 5.1, 'average_rate_per_unit' => 7.6],
        ]);
    }

    public function calculateResidential($data, $state)
    {
        $bill = $data['monthly_bill'] ?? 0;
        $cons = $data['monthly_consumption'] ?? 0;

        // Avoid null / empty bill division
        $monthlyConsumption = $cons > 0
            ? $cons
            : ($bill > 0 ? $bill / 7 : 0); // Avg ₹7 per unit

        $desiredCapacity = $data['desired_capacity'] ?? $this->capacityFromConsumption($monthlyConsumption);
        
        return $this->buildCalculationResult(
            $desiredCapacity,
            $monthlyConsumption,
            $state,
            $data['panel_wattage'],
            'residential'
        );
    }

    public function calculateCommercial($data, $state)
    {
        $bill = $data['monthly_bill'] ?? 0;
        $cons = $data['monthly_consumption'] ?? 0;

        $monthlyConsumption = $cons > 0
            ? $cons
            : ($bill > 0 ? $bill / 8 : 0); // Avg ₹8 per unit
        
        $desiredCapacity = $data['desired_capacity'] ?? $this->capacityFromConsumption($monthlyConsumption);
        
        $result = $this->buildCalculationResult(
            $desiredCapacity,
            $monthlyConsumption,
            $state,
            $data['panel_wattage'],
            'commercial'
        );

        // Commercial subsidy logic
        $result['central_subsidy'] = 0; // No central subsidy for commercial
        $result['state_subsidy'] = $this->getStateSubsidy($state, 'commercial');
        $result['total_subsidy'] = $result['state_subsidy'];
        $result['effective_cost'] = $result['installation_cost'] - $result['total_subsidy'];

        return $result;
    }

    public function calculateIndustrial($data, $state)
    {
        $bill = $data['monthly_bill'] ?? 0;
        $cons = $data['monthly_consumption'] ?? 0;

        $monthlyConsumption = $cons > 0
            ? $cons
            : ($bill > 0 ? $bill / 10 : 0); // Avg ₹10 per unit

        $desiredCapacity = $data['desired_capacity'] ?? $this->capacityFromConsumption($monthlyConsumption);

        // Industrial systems are typically larger
        $minCapacity = 100; // Minimum 100 kW
        $maxCapacity = 500; // Maximum 500 kW for subsidy
        $desiredCapacity = max($minCapacity, min($desiredCapacity, $maxCapacity));

        $result = $this->buildCalculationResult(
            $desiredCapacity,
            $monthlyConsumption,
            $state,
            $data['panel_wattage'],
            'industrial'
        );

        // Industrial subsidy logic
        $result['central_subsidy'] = 0; // No central subsidy for industrial
        $result['state_subsidy'] = $this->getStateSubsidy($state, 'industrial');
        $result['total_subsidy'] = $result['state_subsidy'];
        $result['effective_cost'] = $result['installation_cost'] - $result['total_subsidy'];
        $result['industrial_benefits'] = [
            'tax_depreciation' => $result['installation_cost'] * 0.40,
            'electricity_duty_waiver' => true,
            'net_metering' => true,
        ];

        return $result;
    }

    private function buildCalculationResult($capacity, $consumption, $state, $panelWattage, $type)
    {
        // Safety: avoid division by zero if somehow panelWattage missing
        $panelWattage = max(1, (int) $panelWattage);

        // Safety: capacity cannot be negative
        $capacity = max(0, (float) $capacity);

        $panelCount = ($capacity * 1000) / $panelWattage;
        $areaRequired = $capacity * self::AREA_PER_KW;
        
        // Monthly generation (kWh)
        $monthlyGeneration = $capacity * $state->solar_irradiance * 30 * (1 - self::ANNUAL_EFFICIENCY_LOSS);
        $annualGeneration = $monthlyGeneration * 12;

        // Cost calculation
        $costPerKw = match (true) {
            $capacity <= 5 => 60000,
            $capacity <= 10 => 55000,
            default => 50000,
        };

        $installationCost = $capacity * $costPerKw;

        // Savings calculation
        $electricityRate = match ($type) {
            'residential' => 7,
            'commercial' => 8,
            'industrial' => 10,
            default => 7,
        };

        $monthlySavings = $monthlyGeneration * $electricityRate;
        $annualSavings = $monthlySavings * 12;

        // Avoid division by zero here
        $paybackMonths = $monthlySavings > 0
            ? $installationCost / $monthlySavings
            : 0;

        $savingsIn25Years = $annualSavings * 25;

        // CO2 reduction (kg per kWh)
        $co2PerKwh = 0.67;
        $annualCo2Reduction = $annualGeneration * $co2PerKwh;

        return [
            'system_capacity_kw'      => round($capacity, 2),
            'monthly_consumption'     => round($consumption, 2),
            'panel_count'             => round($panelCount),
            'panel_wattage'           => $panelWattage,
            'area_required_sqft'      => round($areaRequired, 2),
            'area_required_sqm'       => round($areaRequired / 10.764, 2),
            'monthly_generation_kwh'  => round($monthlyGeneration, 2),
            'annual_generation_kwh'   => round($annualGeneration, 2),
            'installation_cost'       => round($installationCost, 2),
            'central_subsidy'         => $this->getCentralSubsidy($capacity, $type),
            'monthly_savings'         => round($monthlySavings, 2),
            'annual_savings'          => round($annualSavings, 2),
            'payback_period_months'   => round($paybackMonths, 1),
            'savings_25_years'        => round($savingsIn25Years, 2),
            'co2_reduction_annual'    => round($annualCo2Reduction, 2),
            'solar_irradiance'        => $state->solar_irradiance,
        ];
    }

    private function capacityFromConsumption($consumption)
    {
        // Avoid division by zero if someone changes 120 later
        $perKwMonthly = 120;
        return $perKwMonthly > 0 ? $consumption / $perKwMonthly : 0;
    }

    private function getCentralSubsidy($capacity, $type)
    {
        if ($type === 'residential') {
            if ($capacity <= 3) {
                return $capacity * 50000; // ₹50,000 per kW up to 3 kW
            } elseif ($capacity <= 10) {
                return (3 * 50000) + (($capacity - 3) * 30000); // ₹30,000 per kW for 3-10 kW
            }
        }
        return 0;
    }

    private function getStateSubsidy($state, $type)
    {
        // This would be pulled from database in real implementation
        $subsidies = [
            'residential' => $state->id * 5000, // Mock data
            'commercial'  => 0,
            'industrial'  => $state->id * 1000,
        ];
        return $subsidies[$type] ?? 0;
    }
}
