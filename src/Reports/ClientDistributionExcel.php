<?php

namespace App\Reports;

use App\Entity\Orders\BulkDistribution;
use App\Entity\Orders\BulkDistributionLineItem;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\IWriter;

class ClientDistributionExcel
{

    /**
     * @var BulkDistributionLineItem[]
     */
    protected $reportData;

    /**
     * PartnerTotalsExcel constructor.
     * @param BulkDistributionLineItem[] $reportData
     */
    public function __construct(array $reportData)
    {
        $this->reportData = $reportData;
    }

    /**
     * @return \PhpOffice\PhpSpreadsheet\Writer\IWriter
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function buildExcel(): IWriter
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Headers
        $sheet->fromArray($this->buildHeaders());

        $dataArr = [];
        foreach ($this->reportData as $lineItem) {
            /** @var BulkDistribution $order */
            $order = $lineItem->getOrder();
            $rowArr = [];
            $rowArr[] = $lineItem->getClient()->getName();
            $rowArr[] = $order->getSequenceNo();
            $rowArr[] = $order->getDistributionPeriod()->format('Y-m');
            $rowArr[] = $order->getPartner()->getTitle();
            $rowArr[] = $lineItem->getProduct()->getName();
            $rowArr[] = $lineItem->getQuantity();

            $dataArr[] = $rowArr;
        }
        $sheet->fromArray($dataArr, null, 'A2');

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        return IOFactory::createWriter($spreadsheet, 'Xlsx');
    }

    private function buildHeaders(): array
    {
        return [
            'Client',
            'Distribution ID',
            'Distribution Month ',
            'Partner',
            'Size',
            'Quantity Distributed'
        ];
    }
}
