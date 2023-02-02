<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportParticipants implements FromView, WithEvents, ShouldAutoSize, WithTitle, WithMapping
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        $registrations = $this->data;
        return view('laporan.export-register', compact("registrations"));
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setName('Arial')->setSize(8);
            },
        ];
    }

    public function title(): string
    {
        return 'Laporan Peserta Event';
    }

    public function map($row): array
    {
        return array_merge($this->headings(false), $row);
    }
}
