<?php

if (!defined('ABSPATH')) {
    exit('Direct access denied.');
}

if (!class_exists('MM_FPDF')) {
    require_once(__DIR__ . '/../../libs/artifacts/fpdf182/fpdf.php');
}

class MM_MenuListPDF {

    private MM_FPDF $pdf;

    private array $settings;

    public function __construct($img_url = null)
    {

        $internalSettings = [
            'width' => 200,
            'height' => 130,
            'img_url' => $img_url ?? __DIR__ . '/../../img/background.jpg'
        ];

        $this->settings = $internalSettings;

        $this->createPDF();
    }

    public function getPDF() {
        return $this->pdf->Output();
    }

    private function createPDF() {

        $width = (int) $this->settings['width'];
        $height = ((int) $this->settings['height']);

        $size = [
            $width,
            $height
        ];

        $this->pdf = new MM_FPDF('L', 'mm', $size);
        $this->pdf->AddPage();

        $this->pdf->SetFont('Times', '', 22);

        $this->pdf->SetAutoPageBreak(true, 0);

        $this->pdf->SetMargins(0,0,0);

        $this->generatePDF();
    }

    private function generatePDF() {

        try {

            $data = [
                'title' => MM_DBController::getMenuTitle('fi'),
                'titleEn' => MM_DBController::getMenuTitle('en'),
                'titleSv' => MM_DBController::getMenuTitle('sv'),
                'prices' => MM_DBController::getPriceGroups(),
                'selectedProducts' => MM_DBController::getSelectedProducts()
            ];

        } catch (Exception $exception) {
            die($exception);
        }

        $this->pdf->Image($this->settings['img_url'], 0, 0, $this->settings['width'], $this->settings['height'], 'JPG');
        $this->pdf->MultiCell(0, 25, '', 0, 1);

        forEach($data['selectedProducts'] as $product) {

            $this->pdf->SetFontSize(22);

            $this->pdf->SetX($this->pdf->GetX() + 10);
            $this->pdf->Cell(0, 0, iconv('utf-8', 'cp1252', $product->name_fi), 0, 0);

            $this->pdf->SetFontSize(18);

            $this->pdf->SetY($this->pdf->GetY() + 6);
            $this->pdf->SetX($this->pdf->GetX() + 18);
            $this->pdf->Cell(0, 0, iconv('utf-8', 'cp1252', $product->name_sv), 0, 0);

            $this->pdf->SetY($this->pdf->GetY() + 6);
            $this->pdf->SetX($this->pdf->GetX() + 18);
            $this->pdf->Cell(0, 0, iconv('utf-8', 'cp1252', $product->name_en), 0, 0);

            forEach($data['prices'] as $group) {

                if ($group->id === $product->price_group) {

                    $this->pdf->SetFont('Times', 'B', 26);


                    $this->pdf->SetY($this->pdf->GetY() - 5);
                    $this->pdf->SetX($this->pdf->GetX() + ($this->settings['width'] - $this->pdf->GetX()) - 40);
                    $this->pdf->Cell(0,0, iconv('utf-8', 'cp1252', $group->name), 0, 0);

                    $this->pdf->SetFont('Times', '', 22);

                }

            }

            $this->pdf->SetY($this->pdf->GetY() + 16);

        }

    }

}