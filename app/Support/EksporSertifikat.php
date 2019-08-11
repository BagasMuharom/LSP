<?php

namespace App\Support;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;

final class EksporSertifikat {

    private $spreadsheet;

    private $sertifikat;

    private $columns = [
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q'
    ];
    
    public function __construct($sertifikat)
    {
        $this->sertifikat = $sertifikat;
        $this->spreadsheet = new Spreadsheet();
    }

    /**
     * Mengeset properti dokumen
     *
     * @return void
     */
    private function setProperties()
    {
        $this->spreadsheet->setTitle('Rekapitulasi Sertifikat LSP')
            ->setCreator('LSP Unesa');
    }

    /**
     * Mengeset header
     *
     * @return void
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    private function setHeader()
    {
        $this->spreadsheet->getActiveSheet()
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Nama Pemegang Sertifikat')
            ->setCellValue('C1', 'Bidang')
            ->setCellValue('D1', 'Field')
            ->setCellValue('E1', 'Skema Sertifikasi')
            ->setCellValue('F1', 'Eng Certification Scheme')
            ->setCellValue('G1', 'KBLI')
            ->setCellValue('H1', 'KBJI')
            ->setCellValue('I1', 'Level KKNI')
            ->setCellValue('J1', 'No Urut Cetak Sertifikasi')
            ->setCellValue('K1', 'Tahun Cetak')
            ->setCellValue('L1', 'Kode Unit SKKNI')
            ->setCellValue('M1', 'Kode Lisensi')
            ->setCellValue('N1', 'No Urut Skema')
            ->setCellValue('O1', 'Tahun')
            ->setCellValue('P1', 'Kualifikasi')
            ->setCellValue('Q1', 'Eng Qualification')
            ->setCellValue('R1', 'Issue Date')
            ->setCellValue('S1', 'Expire Date')
            ->setCellValue('T1', 'Tanggal Cetak');

        foreach ($this->columns as $column) {
            $this->spreadsheet->getActiveSheet()
                ->getColumnDImension($column)
                ->setAutoSize(true);
        }
    }

    /**
     * Mengisi dokumen dengan data sertifikat
     *
     * @return void
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    private function generate()
    {
        $this->setHeader();

        foreach ($this->sertifikat as $index => $sertifikat)
        {
            $index += 2; 
            $skema = $sertifikat->getSkema(false);
            $this->spreadsheet->getActiveSheet()
                ->setCellValue('A' . $index, $index - 1)
                ->setCellValue('B' . $index, $sertifikat->nama_pemegang)
                ->setCellValue('C' . $index, $skema->bidang)
                ->setCellValue('D' . $index, $skema->field)
                ->setCellValue('E' . $index, $skema->nama)
                ->setCellValue('F' . $index, $skema->nama_english)
                ->setCellValue('G' . $index, $skema->kbli)
                ->setCellValue('H' . $index, $skema->kbji)
                ->setCellValue('I' . $index, $skema->level_kkni)
                ->setCellValue('J' . $index, $sertifikat->no_urut_cetak)
                ->setCellValue('K' . $index, $sertifikat->tahun_cetak)
                ->setCellValue('L' . $index, $skema->kode_unit_skkni)
                ->setCellValue('M' . $index, 249)
                ->setCellValue('N' . $index, $sertifikat->no_urut_skema)
                ->setCellValue('O' . $index, $sertifikat->tahun)
                ->setCellValue('P' . $index, $skema->kualifikasi)
                ->setCellValue('Q' . $index, $skema->qualification)
                ->setCellValue('R' . $index, Carbon::parse($sertifikat->issue_date)->format('F j, Y'))
                ->setCellValue('S' . $index, Carbon::parse($sertifikat->expire_date)->format('F j, Y'))
                ->setCellValue('T' . $index, Carbon::parse($sertifikat->tanggal_cetak)->format('F j, Y'));
        }
    }

    /**
     * Melakukan ekspor
     *
     * @return void
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export()
    {
        $this->generate();

        $writer = IOFactory::createWriter($this->spreadsheet, 'Xlsx');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Sertifikat.xlsx"');
        $writer->save("php://output");
    }

}