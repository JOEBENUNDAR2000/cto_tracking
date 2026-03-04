<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    protected $ctoService;

    public function __construct()
    {
        $this->ctoService = service('ctoService');
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD HOME
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        return view('dashboard', $this->ctoService->getDashboardData());
    }

    /*
    |--------------------------------------------------------------------------
    | CTO APPLICATION FORM
    |--------------------------------------------------------------------------
    */
    public function ctoApplication()
    {
        return view('cto_application');
    }

    /*
    |--------------------------------------------------------------------------
    | CTO LEDGER
    |--------------------------------------------------------------------------
    */
    public function ctoLedger()
    {
        $search = $this->request->getGet('search');
        $ledgerData = $this->ctoService->getLedger($search);

        return view('cto_ledger', [
            'applications' => $ledgerData['applications'],
            'search'       => $search
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | REPORT PAGE
    |--------------------------------------------------------------------------
    */
    public function report()
    {
        $month    = $this->request->getGet('month');
        $employee = $this->request->getGet('employee');

        return view(
            'report',
            $this->ctoService->getAllReports($month, $employee)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PDF EXPORT  (based on your route)
    |--------------------------------------------------------------------------
    | Route: $routes->get('/report/pdf', 'Dashboard::pdf');
    */
   public function pdf()
{
    $month    = $this->request->getGet('month');
    $employee = $this->request->getGet('employee');

    return $this->ctoService->generatePdf($month, $employee);
}
    /*
    |--------------------------------------------------------------------------
    | SAVE CTO APPLICATION
    |--------------------------------------------------------------------------
    */
    public function saveCto()
    {
        $this->ctoService->saveCto($this->request->getPost());

        return redirect()
            ->to('/cto-application')
            ->with('success', 'CTO Application Submitted Successfully!');
    }
}