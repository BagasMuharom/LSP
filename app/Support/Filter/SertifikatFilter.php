<?php

namespace App\Support\Filter;

use Illuminate\Http\Request;
use Carbon\Carbon;

trait SertifikatFilter {

    private $query;

    private $request;

    /**
     * Melakukan filter
     *
     * @param Request $request
     * @param App\Models\Sertifikat|\Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function simplifyFilter(Request $request, $query)
    {
        $this->request = $request;
        $this->query = $query;

        $this->filterByKeyword();
        $this->filterByAkademik();
        $this->filterByTanggalCetak();

        return $this->query;
    }

    /**
     * Melakukan filter berdasarkan keyword
     * 
     * @return keyword
     */
    private function filterByKeyword()
    {
        $request = $this->request;

        $this->query = $this->query->when($request->has('keyword'), function ($query) use ($request) {
            $query->where(function ($query) use ($request) {
                $query->where('nomor_sertifikat', $request->keyword)
                    ->orWhereHas('getUji', function ($query) use ($request) {
                        $query->whereHas('getMahasiswa', function ($query) use ($request) {
                            $query->where('nama', 'ILIKE', '%' . $request->keyword . '%');
                        });
                    });
            });
        });
    }

    /**
     * Melakukan filter berdasarkan tingkatan akademik
     *
     * @return void
     */
    private function filterByAkademik()
    {
        $request = $this->request;
        $filterFakultas = $request->has('fakultas') && $request->fakultas > 0;
        $filterJurusan = $request->has('jurusan') && $request->jurusan > 0;
        $filterProdi = $request->has('prodi') && $request->prodi > 0;

        $this->query = $this->query->when($filterFakultas, function ($query) use ($request, $filterJurusan, $filterProdi) {

            $query->whereHas('getUji.getMahasiswa.getProdi', function ($query) use ($request, $filterJurusan, $filterProdi) {

                $query->whereHas('getJurusan', function ($query) use ($request, $filterJurusan) {

                    $query->where('fakultas_id', $request->fakultas)
                        ->when($filterJurusan, function ($query) use ($request) {
                            $query->where('id', $request->jurusan);
                        });

                })->when($filterProdi, function ($query) use ($request) {
                    $query->where('id', $request->prodi);
                });

            });

        });
    }

    /**
     * Melakukan filter berdasarkan tanggal cetak
     *
     * @return void
     */
    private function filterByTanggalcetak()
    {
        $tgl_mulai = Carbon::parse($this->request->tgl_cetak_mulai);
        $tgl_akhir = Carbon::parse($this->request->tgl_cetak_akhir);

        $this->query = $this->query->when((!is_null($this->request->tgl_cetak_mulai) && !is_null($this->request->tgl_cetak_mulai)), function ($query) use ($tgl_mulai, $tgl_akhir) {
            $query->whereBetween('tanggal_cetak', [
                $tgl_mulai, $tgl_akhir
            ]);
        });
    }

}