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
            ->setCellValue('C1', 'Skema Sertifikasi')
            ->setCellValue('D1', 'KBLI')
            ->setCellValue('E1', 'KBJI')
            ->setCellValue('F1', 'Level KKNI')
            ->setCellValue('G1', 'No Urut Cetak Sertifikasi')
            ->setCellValue('H1', 'Tahun Cetak')
            ->setCellValue('I1', 'Kode Unit SKKNI')
            ->setCellValue('J1', 'Kode Lisensi')
            ->setCellValue('K1', 'No Urut Skema')
            ->setCellValue('L1', 'Tahun')
            ->setCellValue('M1', 'Kualifikasi')
            ->setCellValue('N1', 'Eng Qualification')
            ->setCellValue('O1', 'Issue Date')
            ->setCellValue('P1', 'Expire Date')
            ->setCellValue('Q1', 'Tanggal Cetak');

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
                ->setCellValue('C' . $index, $skema->nama)
                ->setCellValue('D' . $index, $skema->kbli)
                ->setCellValue('E' . $index, $skema->kbji)
                ->setCellValue('F' . $index, $skema->level_kkni)
                ->setCellValue('G' . $index, $sertifikat->no_urut_cetak)
                ->setCellValue('H' . $index, $sertifikat->tahun_cetak)
                ->setCellValue('I' . $index, $skema->kode_unit_skkni)
                ->setCellValue('J' . $index, 249)
                ->setCellValue('K' . $index, $sertifikat->no_urut_skema)
                ->setCellValue('L' . $index, $sertifikat->tahun)
                ->setCellValue('M' . $index, $skema->kualifikasi)
                ->setCellValue('N' . $index, $skema->qualification)
                ->setCellValue('O' . $index, Carbon::parse($sertifikat->issue_date)->format('F j, Y'))
                ->setCellValue('P' . $index, Carbon::parse($sertifikat->expire_date)->format('F j, Y'))
                ->setCellValue('Q' . $index, Carbon::parse($sertifikat->tanggal_cetak)->format('F j, Y'));
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