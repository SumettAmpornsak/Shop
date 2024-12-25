<?php
// เชื่อมต่อฐานข้อมูล
include 'config.php';

$format = $_GET['format'];

$salesQuery = "
    SELECT p.name, s.amount, s.sale_date 
    FROM sales s 
    JOIN products p ON s.product_id = p.id
";
$salesResult = mysqli_query($conn, $salesQuery);

if ($format == 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="sales_report.csv"');
    
    $output = fopen('php://output', 'w');
    fputcsv($output, ['ชื่อสินค้า', 'ยอดขาย', 'วันที่ขาย']); // หัวตาราง

    while ($row = mysqli_fetch_assoc($salesResult)) {
        fputcsv($output, [$row['product_name'], $row['amount'], $row['sale_date']]);
    }
    
    fclose($output);
    exit;
}

if ($format == 'pdf') {
    require('fpdf/fpdf.php'); // เพิ่มไลบรารี FPDF

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Kanit', 'B', 16);
    $pdf->Cell(0, 10, 'รายงานยอดขาย', 0, 1, 'C');

    $pdf->SetFont('Kanit', '', 12);
    $pdf->Cell(60, 10, 'ชื่อสินค้า', 1);
    $pdf->Cell(60, 10, 'ยอดขาย', 1);
    $pdf->Cell(60, 10, 'วันที่ขาย', 1);
    $pdf->Ln();

    while ($row = mysqli_fetch_assoc($salesResult)) {
        $pdf->Cell(60, 10, $row['product_name'], 1);
        $pdf->Cell(60, 10, number_format($row['amount'], 2) . ' บาท', 1);
        $pdf->Cell(60, 10, $row['sale_date'], 1);
        $pdf->Ln();
    }

    $pdf->Output('D', 'sales_report.pdf'); // ส่งออกไฟล์ PDF
    exit;
}
