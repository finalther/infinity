<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$pdf->SetMargins(20, 15, 20);
	$title = 'Cetak Form Cuti Karyawan';
	$pdf->SetTitle($title);
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','UB',18);
	$w = $pdf->GetStringWidth("FORM CUTI");
	$pdf->SetX(($pdf->w -$w)/2);
	$pdf->Cell($w,9,"FORM CUTI",0,0,'C');
	$pdf->Ln(7);
	$w = $pdf->GetStringWidth("No. ..../FC-HR/..../2017");
	$pdf->SetX(($pdf->w -$w)/2);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell($w,9,"No. ..../FC-HR/..../2017",0,0,'C');
	$pdf->Ln(15);
	$pdf->Cell(10);
	$pdf->Cell(1,6,"Nama",0,0,'L');
	$pdf->Cell(48);
	$pdf->Cell(2,6," : Alif Bintoro",0,1,'L');
	$pdf->Cell(10);
	$pdf->Cell(1,6,"Jabatan",0,0,'L');
	$pdf->Cell(48);
	$pdf->Cell(2,6," : Staff IT",0,1,'L');
	$pdf->Cell(10);
	$pdf->Cell(1,6,"Tanggal Cuti",0,0,'L');
	$pdf->Cell(48);
	$pdf->Cell(2,6," : 1 Desember 2017",0,1,'L');
	$pdf->Cell(10);
	$pdf->Cell(1,6,"Tujuan",0,0,'L');
	$pdf->Cell(48);
	$pdf->Cell(2,6," : Liburan",0,1,'L');
	$pdf->Cell(10);
	$pdf->Cell(1,6,"Sudah Pernah Cuti tahun ini",0,0,'L');
	$pdf->Cell(48);
	$pdf->Cell(2,6," : 0 Kali",0,1,'L');
	$pdf->Cell(10);
	$pdf->Cell(1,6,"Pengganti Selama Cuti",0,0,'L');
	$pdf->Cell(48);
	$pdf->Cell(2,6," : Tidak Ada Pengganti",0,1,'L');
	$pdf->ln(8);
	$pdf->Cell(0,6,"Surakarta, 25 April 2017",0,1,'R');
	$pdf->Cell(0,6,"Pemohon",0,1,'R');
	$pdf->ln(20);
	$pdf->Cell(0,6,"(Alif Bintoro)",0,1,'R');
	$pdf->ln(5);
	$pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX()+($pdf->w-40), $pdf->GetY());
	$pdf->ln(5);
	$pdf->MultiCell(0,6,"Saya sebagai atasan si pemohon (menyetujui / menunda / tidak menyetujui)* permohonan cuti karena .......................................................................................................................... dengan catatan bahwa yang bersangkutan dapat dipanggil kembali dari cutinya apabila ada kepentingan yang mendesak dan membutuhkan kehadiran yang bersangkutan.");
	$pdf->ln(5);
	$pdf->Cell(0,6,"Atasan Pemohon",0,1,'R');
	$pdf->ln(20);
	$pdf->Cell(0,6,"(Alif Bintoro)",0,1,'R');
	$pdf->ln(5);
	$pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX()+($pdf->w-40), $pdf->GetY());
	$pdf->ln(5);
	$pdf->Cell(0,6,"Mengetahui HRD",0,1,'L');
	$pdf->ln(20);
	$pdf->Cell(0,6,"(Alif Bintoro)",0,1,'L');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,6,"* coret yang tidak perlu",0,1,'L');
	$pdf->Output("FormCuti_Alif_Bintoro_25112017.pdf","I");