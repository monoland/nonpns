<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NominativeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $front = optional($this->teacher)->front_title ? optional($this->teacher)->front_title . ' ' : '';
        $back = optional($this->teacher)->back_title ? ', ' . optional($this->teacher)->back_title . ' ' : '';

        return [
            'fullname' => trim($front . optional($this->teacher)->name . $back),
            'nik' => optional($this->teacher)->nik,
            'number' => $this->number,
            'tmt' => $this->tmt_indo($this->tmt->format('d-m-Y')),
            'serial' => $this->serial,
            'school' => optional($this->school)->name,
            'subject' => $this->subject,
            'shorturl' => $this->shorturl,
        ];
    }

    protected function tmt_indo($tmt)
    {
        $bulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'Nopember',
            '12' => 'Desember',
        ];

        $tanggal = explode('-', $tmt);

        return $tanggal[0] . ' ' . $bulan[$tanggal[1]] . ' ' . $tanggal[2];
    }
}
