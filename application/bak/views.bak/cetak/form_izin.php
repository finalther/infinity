<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$pdf->SetMargins(20, 15, 20);
    $title = 'Cetak Form Izin Karyawan';
    $pdf->SetTitle($title);
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','UB',18);
    $w = $pdf->GetStringWidth("FORM IZIN KARYAWAN");
    $pdf->SetX(($pdf->w -$w)/2);
    $pdf->Cell($w,9,"FORM IZIN KARYAWAN",0,0,'C');
    $pdf->Ln(15);
    $pdf->Cell(10);
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(1,6,"Nama",0,0,'L');
    $pdf->Cell(48);
    $pdf->Cell(2,6," : Alif Bintoro",0,1,'L');
    $pdf->Cell(10);
    $pdf->Cell(1,6,"Posisi",0,0,'L');
    $pdf->Cell(48);
    $pdf->Cell(2,6," : Staff IT",0,1,'L');
    $pdf->Cell(10);
    $pdf->Cell(1,6,"Divisi",0,0,'L');
    $pdf->Cell(48);
    $pdf->Cell(2,6," : IT",0,1,'L');
    $pdf->Cell(10);
    $pdf->Cell(1,6,"Tanggal",0,0,'L');
    $pdf->Cell(48);
    $pdf->Cell(2,6," : 1 Desember 2017",0,1,'L');
    $pdf->ln(8);
    $pdf->Cell(0,6,"Mengajukan Izin : ",0,1,'L');
    $pdf->ln(5);
    $pdf->SetFont('Arial','B',12);
    $w = $pdf->GetStringWidth("\"TIDAK MASUK KERJA\"");
    $pdf->SetX(($pdf->w -$w)/2);
    $pdf->Cell($w,9,"\"TIDAK MASUK KERJA\"",0,1,'C');
    $pdf->ln(5);
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(0,6,"Hal Tersebut Diatas Terjadi Karena : ",0,1,'L');
    $pdf->MultiCell(0,6,"Saya sedang ada urusan mendesak yang tidak dapat ditunda lagi.");
    $pdf->ln(10);
    $pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX()+($pdf->w-40), $pdf->GetY());
    $pdf->ln(10);
    $pdf->Cell(0,6,"Yang bertandatangan dibawah ini : ",0,1,'C');
    $pdf->Cell(0,6,"Pemohon :",0,0,'L');
    $pdf->Cell(0,6,"Pemberi Izin :",0,1,'R');
    $pdf->ln(20);
    $pdf->Cell(0,6,"(Alif Bintoro)",0,0,'L');
    $pdf->Cell(0,6,"(Alif Bintoro)",0,1,'R');
    $pdf->Output("FormIzin_Alif_Bintoro_25112017.pdf","I");