<?php

namespace App\Support;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Sertifikat;
use App\Models\Skema;

class ImportSertifikat
{

    protected $reader;

    protected $content;

    protected $header;

    protected $fields = [
        'Nama Pemegang Sertifikat' => null,
        'Skema Sertifikasi' => null,
        'No Urut Cetak Sertifikasi' => null,
        'No Urut Skema' => null, 
        'Tahun' => null, 
        'Issue Date' => null, 
        'Expire Date' => null, 
        'Tanggal Cetak' => null
    ];

    public function __construct()
    {
        $this->reader = new Xlsx();
    }

    /**
     * Membaca dari lokasi atau file
     *
     * @param string|object $location
     * @return Excel
     */
    public function read($location)
    {
        $this->content = $this->reader->load($location);
        $this->initHeader();

        return $this;
    }

    /**
     * Melakukan proses import
     *
     * @return void
     */
    public function import()
    {
        $content = collect($this->toArray());
        $fields = $this->fields;

        $content->each(function ($item, $key) use ($fields) {
            if ($key > 1) {
                try {
                    $skema = Skema::where('nama', $item[$fields['Skema Sertifikasi']])->firstOrFail();
                    Sertifikat::create([
                        'skema_id' => $skema->id,
                        'nama_pemegang' => $item[$fields['Nama Pemegang Sertifikat']],
                        'no_urut_cetak' => $item[$fields['No Urut Cetak Sertifikasi']],
                        'no_urut_skema' => $item[$fields['No Urut Skema']],
                        'tahun' => $item[$fields['Tahun']],
                        'issue_date' => $item[$fields['Issue Date']],
                        'expire_date' => $item[$fields['Expire Date']],
                        'tanggal_cetak' => $item[$fields['Tanggal Cetak']]
                    ]);
                }
                catch (ModelNotFoundException $e) {}
            }
        });
    }

    /**
     * Mengisialisasi baris awal sebagai header dan mendapatkan index untuk kolom
     * yang diinginkan
     *
     * @return void
     */
    public function initHeader()
    {
        $content = collect($this->toArray());
        $header = $content->first();
        $availablefields = collect($this->fields)->keys()->toArray();

        foreach ($header as $index => $column) {
            if (in_array($column, $availablefields)) {
                $this->fields[$column] = $index;
            }
        }
    }

    /**
     * Mendapatkan isi dokumen dalam bentuk array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->content->getActiveSheet()->toArray(null, true, true, true);
    }

    /**
     * Mendapatkan object reader Xlsx
     *
     * @return Xlsx
     */
    public function getReader()
    {
        return $this->reader;
    }
    
    /**
     * Mendapatkan header dari file
     * 
     * @return array
     */
    public function getHeader()
    {
        return $this->fields;
    }

}