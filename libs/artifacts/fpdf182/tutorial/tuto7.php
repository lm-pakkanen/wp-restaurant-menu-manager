<?php
define('MM_FPDF_FONTPATH','.');
require('../MM_FPDF.php');

$pdf = new MM_FPDF();
$pdf->AddFont('Calligrapher','','calligra.php');
$pdf->AddPage();
$pdf->SetFont('Calligrapher','',35);
$pdf->Cell(0,10,'Enjoy new fonts with MM_FPDF!');
$pdf->Output();
?>
