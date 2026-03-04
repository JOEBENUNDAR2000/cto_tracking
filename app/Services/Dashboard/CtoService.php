<?php

namespace App\Services\Dashboard;

use App\Models\CtoApplicationModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class CtoService
{
    protected $model;

    public function __construct()
    {
        $this->model = new CtoApplicationModel();
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD DATA
    |--------------------------------------------------------------------------
    */
    public function getDashboardData()
    {
        $totalEarned = $this->model
            ->selectSum('total_earned_hours')
            ->first()['total_earned_hours'] ?? 0;

        $totalUsed = $this->model
            ->selectSum('total_used_hours')
            ->first()['total_used_hours'] ?? 0;

        $totalRemaining = $this->model
            ->selectSum('remaining_coc')
            ->first()['remaining_coc'] ?? 0;

        $totalEmployees = $this->model->countAll();

        $monthlyData = $this->model
            ->select('month,
                      SUM(total_earned_hours) as earned,
                      SUM(total_used_hours) as used')
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->findAll();

        $employmentData = $this->model
            ->select('employment_type, COUNT(id) as total')
            ->groupBy('employment_type')
            ->findAll();

        return [
            'totalEarned'     => $totalEarned,
            'totalUsed'       => $totalUsed,
            'totalRemaining'  => $totalRemaining,
            'totalEmployees'  => $totalEmployees,
            'monthly'         => $monthlyData,
            'employment'      => $employmentData
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | CTO LEDGER
    |--------------------------------------------------------------------------
    */
   public function getLedger($search = null)
{
    $builder = $this->model->builder();

    if (!empty($search)) {
        $builder->groupStart()
                ->like('employee_name', $search)
                ->orLike('remarks', $search)
                ->groupEnd();
    }

    $applications = $builder
        ->orderBy('id', 'ASC')
        ->get()
        ->getResultArray();

    return [
        'applications' => $applications
    ];
}

    /*
    |--------------------------------------------------------------------------
    | REPORT FILTER
    |--------------------------------------------------------------------------
    */
    public function getAllReports($month = null, $employee = null)
    {
        $builder = $this->model->builder();
        $builder->select('*');

        if (!empty($month)) {
            $builder->where('month', $month);
        }

        if (!empty($employee)) {
            $builder->where('employee_name', $employee);
        }

        $builder->orderBy('id', 'ASC');

        $applications = $builder->get()->getResultArray();

        $employees = $this->model
            ->select('employee_name')
            ->distinct()
            ->orderBy('employee_name', 'ASC')
            ->findAll();

        return [
            'applications'      => $applications,
            'employees'         => $employees,
            'selectedMonth'     => $month,
            'selectedEmployee'  => $employee
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | SAVE CTO
    |--------------------------------------------------------------------------
    */
    public function saveCto($postData)
    {
        $earned = (float) ($postData['total_earned_hours'] ?? 0);
        $used   = (float) ($postData['total_used_hours'] ?? 0);

        return $this->model->save([
            'month'              => $postData['month'] ?? null,
            'employee_name'      => $postData['employee_name'] ?? null,
            'division'           => $postData['division'] ?? null,
            'employment_type'    => $postData['employment_type'] ?? null,
            'date_filing'        => $postData['date_filing'] ?? null,
            'inclusive_date'     => $postData['inclusive_date'] ?? null,
            'total_earned_hours' => $earned,
            'total_used_hours'   => $used,
            'remaining_coc'  => $earned - $used,
            'remarks'            => $postData['remarks'] ?? null
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | GENERATE PDF
    |--------------------------------------------------------------------------
    | Uses: app/Views/report_pdf.php
    */
    public function generatePdf($month = null, $employee = null)
    {
        $data = $this->getAllReports($month, $employee);
        $applications = $data['applications'];

        // Calculate totals
        $totalEarned = 0;
        $totalUsed = 0;
        $totalRemaining = 0;

        foreach ($applications as $row) {
            $totalEarned += $row['total_earned_hours'];
            $totalUsed += $row['total_used_hours'];
            $totalRemaining += $row['remaining_coc'];
        }

        // Load correct view (IMPORTANT FIX)
        $html = view('report_pdf', [
            'applications'   => $applications,
            'totalEarned'    => $totalEarned,
            'totalUsed'      => $totalUsed,
            'totalRemaining' => $totalRemaining,
            'generatedDate'  => date('F d, Y h:i A')
        ]);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream("CTO_Report.pdf", [
            "Attachment" => false
        ]);
    }
}