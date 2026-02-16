<?php

namespace App\Exports;

use App\Models\CarbonEmission;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmissionExport implements FromQuery, WithHeadings, WithMapping
{
    protected $periodId;

    public function __construct(int $periodId)
    {
        $this->periodId = $periodId;
    }

    public function query()
    {
        return CarbonEmission::query()
            ->where('period_id', $this->periodId)
            ->with(['factor.category']);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Categoría',
            'Alcance',
            'Fuente / Factor',
            'Unidad',
            'Cantidad (Actividad)',
            'Gases: CO2',
            'Gases: CH4',
            'Gases: N2O',
            'Gases: NF3',
            'Gases: SF6',
            'Total tCO2e',
            'Incertidumbre (%)',
            'Fecha de Registro',
            'Notas'
        ];
    }

    public function map($emission): array
    {
        return [
            $emission->id,
            $emission->factor->category->name ?? 'N/A',
            $emission->factor->category->scope ?? 'N/A',
            $emission->factor->name,
            $emission->factor->unit,
            $emission->quantity,
            $emission->emissions_co2,
            $emission->emissions_ch4,
            $emission->emissions_n2o,
            $emission->emissions_nf3,
            $emission->emissions_sf6,
            $emission->calculated_co2e,
            $emission->uncertainty_result,
            $emission->created_at->toDateTimeString(),
            $emission->notes
        ];
    }
}
