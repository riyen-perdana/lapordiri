<?php

namespace App\Observers;

use App\Models\Ppg;
use App\Models\Set;
use Illuminate\Support\Facades\DB;

class PpgObserver
{
    /**
     * Handle the Ppg "created" event.
     */
    public function created(Ppg $ppg): void
    {
        //
    }

    /**
     * Handle the Ppg "updated" event.
     */
    public function updated(Ppg $ppg): void
    {
        if ($ppg->isDirty('ppg_sts_vrf')) {

            if (!$ppg->ppg_nim) {
                try {

                    DB::beginTransaction();
                    
                    //Cari Tahun Peserta
                    $thn = $ppg->set->set_thn;

                    //Cari Jumlah Peserta
                    $jlmh = Ppg::whereNotNull('ppg_nim')->count();

                    //Cari Jenis Kelamin
                    $jk = $ppg->ppg_jk == 'L' ? '1' : '2';

                    //Gabungkan NIM
                    $nim = '4' . substr($thn, 2, 2) . '115' . $jk . str_pad($jlmh + 1, 4, '0', STR_PAD_LEFT);

                    //Update NIM
                    $ppg->update([
                        'ppg_nim' => $nim
                    ]);

                    DB::commit();

                } catch (\Throwable $th) {
                    throw $th;
                    DB::rollBack();
                }
            }
        }
    }

    /**
     * Handle the Ppg "deleted" event.
     */
    public function deleted(Ppg $ppg): void
    {
        //
    }

    /**
     * Handle the Ppg "restored" event.
     */
    public function restored(Ppg $ppg): void
    {
        //
    }

    /**
     * Handle the Ppg "force deleted" event.
     */
    public function forceDeleted(Ppg $ppg): void
    {
        //
    }
}
