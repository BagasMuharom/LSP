<?php

namespace App\Support\Filter;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;

trait MahasiswaFilter {

    private $request;

    private $query;

    /**
     * Melakukan filter
     *
     * @param Request $request
     * @param Mahasiswa|Builder $query
     * @return void
     */
    private function simplifyFilter(Request $request, $query)
    {   
        $this->request = $request;
        $this->query = $query;

        $this->filterByStatus();
        $this->filterByKeyword();
        $this->filterByAkademik();

        return $this->query;
    }
    
    /**
     * Melakukan filter berdasarkan status
     * 
     * @return void
     */
    private function filterByStatus()
    {
        if (!$this->request->has('status'))
            return;

        switch($this->request->status) {
            case Mahasiswa::AKTIF:
                $this->query = $this->query->where('terblokir', false)->where('terverifikasi', true);
                break;
            case Mahasiswa::TERBLOKIR:
                $this->query = $this->query->where('terblokir', true);
                break;
            case Mahasiswa::BELUM_TERVERIFIKASI:
                $this->query = $this->query->where('terverifikasi', false);
                break;
        }
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
                $query->where('nim', $request->keyword)
                    ->orWhere('nama', 'ILIKE', '%' . $request->keyword . '%');
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
            $query->whereHas('getProdi', function ($query) use ($request, $filterJurusan, $filterProdi) {
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

}