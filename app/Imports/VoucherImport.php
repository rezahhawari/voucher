<?php

namespace App\Imports;

use App\Models\Period;
use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Illuminate\Support\Str;

class VoucherImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $dataperiod = Period::where('period_id', $row['durationid'])->first();

        // dd($dataperiod);
        return new Voucher([
            'voucher_id' => Str::password(16, symbols: false),
            'code' => $row['code'],
            'period_id' => $dataperiod->id,
            'venue_id' => $dataperiod->venue_id,
            'status' => 1,
            'user_id' => Auth::user()->id,
        ]);
    }
}
