<?php

namespace App\Support;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;

final class EksporUji {

    private $spreadsheet;

    private $uji;

    private $columns = [
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T'
    ];
    
    public function __construct($uji)
    {
        $this->uji = $uji;
        $this->spreadsheet = new Spreadsheet();
    }

    /**
     * Mengeset properti dokumen
     *
     * @return void
     */
    private function setProperties()
    {
        $this->spreadsheet->setTitle('Rekapitulasi Uji LSP')
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
            ->setCellValue('B1', 'Nama Peserta')
            ->setCellValue('C1', 'NIK')
            ->setCellValue('D1', 'Tempat Lahir')
            ->setCellValue('E1', 'Tanggal Lahir')
            ->setCellValue('F1', 'Jenis Kelamin')
            ->setCellValue('G1', 'Tempat Tinggal')
            ->setCellValue('H1', 'Kab/Kota')
            ->setCellValue('I1', 'Provinsi')
            ->setCellValue('J1', 'TELP')
            ->setCellValue('K1', 'EMAIL')
            ->setCellValue('L1', 'PENDIDIKAN')
            ->setCellValue('M1', 'PEKERJAAN')
            ->setCellValue('N1', 'SKEMA')
            ->setCellValue('O1', 'Tanggal Uji')
            ->setCellValue('P1', 'Tempat Uji')
            ->setCellValue('Q1', 'Asesor')
            ->setCellValue('R1', 'Sumber Anggaran')
            ->setCellValue('S1', 'Kementrian / Instansi / Dinas')
            ->setCellValue('T1', 'K / BK');

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

        foreach ($this->uji as $index => $uji)
        {
            $index += 2; 
            $skema = $uji->getSkema(false);
            $mahasiswa = $uji->getMahasiswa(false);
            $tuk = $skema->getTempatUji(false);
            $dana = $uji->getEvent(false)->getDana(false);

            $this->spreadsheet->getActiveSheet()
                ->setCellValue('A' . $index, $index - 1)
                ->setCellValue('B' . $index, $mahasiswa->nama)
                ->setCellValue('C' . $index, $mahasiswa->nik)
                ->setCellValue('D' . $index, $mahasiswa->tempat_lahir)
                ->setCellValue('E' . $index, $mahasiswa->tgl_lahir)
                ->setCellValue('F' . $index, $mahasiswa->jenis_kelamin)
                ->setCellValue('G' . $index, $mahasiswa->alamat)
                ->setCellValue('H' . $index, $mahasiswa->kabupaten)
                ->setCellValue('I' . $index, $mahasiswa->provinsi)
                ->setCellValue('J' . $index, $mahasiswa->no_telepon)
                ->setCellValue('K' . $index, $mahasiswa->email)
                ->setCellValue('L' . $index, $mahasiswa->pendidikan)
                ->setCellValue('M' . $index, $mahasiswa->pekerjaan)
                ->setCellValue('N' . $index, $skema->nama)
                ->setCellValue('O' . $index, $uji->tanggal_uji)
                ->setCellValue('P' . $index, $tuk->nama)
                ->setCellValue('Q' . $index, $uji->asesor)
                ->setCellValue('R' . $index, $dana->nama)
                ->setCellValue('S' . $index, 'Universitas Negeri Surabaya')
                ->setCellValue('T' . $index, $uji->isLulus() ? 'K' : 'BK');
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