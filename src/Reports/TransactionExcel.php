<?php

namespace App\Reports;

use App\Entity\InventoryTransaction;
use App\Entity\Orders\AdjustmentOrder;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\IWriter;

class TransactionExcel
{

    /**
     * @var InventoryTransaction[]
     */
    protected $reportData;

    /**
     * PartnerTotalsExcel constructor.
     * @param InventoryTransaction[] $reportData
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
        foreach ($this->reportData as $transaction) {
            $rowArr = [];
            $rowArr[] = $transaction->getId();
            $rowArr[] = $transaction->getProduct()->getName();
            $rowArr[] = $transaction->getStorageLocation()->getTitle();
            $rowArr[] = $transaction->getDelta();
            $rowArr[] = $transaction->getLineItem()->getOrder()->getOrderTypeName();
            $rowArr[] = $transaction->getLineItem()->getOrder()->getId();
            $rowArr[] = $transaction->getCreatedAt();
            $rowArr[] = $transaction->getLineItem()->getOrder() instanceof AdjustmentOrder
                ? $transaction->getLineItem()->getOrder()->getReason()
                : '';
            $rowArr[] = $transaction->isCommitted() ? "Yes" : "No";
            $rowArr[] = $transaction->getCommittedAt();

            $dataArr[] = $rowArr;
        }
        $sheet->fromArray($dataArr, null, 'A2');

        return IOFactory::createWriter($spreadsheet, 'Xlsx');
    }

    private function buildHeaders()
    {
        $headers = [
            'Transaction ID',
            'Product',
            'Storage Location',
            'Change',
            'Order Type',
            'Order Number',
            'Date Created',
            'Reason',
            'Committed',
            'Date Committed',
        ];

        return $headers;
    }
}
