<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$pdf->SetMargins(20, 15, 20);
	$title = 'Cetak Permintaan Uang ke Keuangan';
	$pdf->SetTitle($title);
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','UB',16);
	$w = $pdf->GetStringWidth("PERMOHONAN PENCARIAN UANG");
	$pdf->SetX(($pdf->w -$w)/2);
	$pdf->Cell($w,9,"PERMOHONAN PENCARIAN UANG",0,0,'C');
	$pdf->Ln(7);
	$w = $pdf->GetStringWidth("No. ..../FC-HR/..../2017");
	$pdf->SetX(($pdf->w -$w)/2);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell($w,9,"No. ..../FC-HR/..../2017",0,0,'C');
	$pdf->Ln(15);
	$pdf->Cell(0,9,"Dengan ini saya,",0,1,'J');
	$pdf->Cell(10);
	$pdf->Cell(1,6,"Nama",0,0,'L');
	$pdf->Cell(48);
	$pdf->Cell(2,6," : Alif Bintoro",0,1,'L');
	$pdf->Cell(10);
	$pdf->Cell(1,6,"Jabatan",0,0,'L');
	$pdf->Cell(48);
	$pdf->Cell(2,6," : Staff IT",0,1,'L');
	$pdf->Ln(10);
	$pdf->MultiCell(0,6,"Mengajukan pencairan uang untuk kegiatan ........ sebesar .......... Lampiran pengajuan pencairan uang kami sertakan dalam attachment surat ini.");
	$pdf->MultiCell(0,6,"Demikian disampaikan, atas perhatian dan kerjasamanya disampaikan terima kasih.");
	$pdf->Ln(10);
	$pdf->Cell(0,6,"Salam,",0,1,"R");
	$pdf->Cell(0,6,"<<jabatan pemohon>>",0,1,"R");
	$pdf->Ln(20);
	$pdf->Cell(0,6,"Alif Bintoro",0,1,"R");
	$pdf->Output("PermintaanKeuangan_CAB0001_25112017.pdf","I");