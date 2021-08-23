<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('preventBackHistory');
        $this->middleware('ProcessRestrictions')->except('view_users','receiving','leadtime_monitoring_mail');
        $this->middleware('user.restrictions')->only('view_users');
        $this->middleware('receiver.restrictions')->only('receiving');
        $this->middleware('checkStatus')->except('view_users','leadtime_monitoring_mail');
    }

    public function view_dashboard_page ()
    {
        return view('Admin.dashboard');
    }

    public function view_master_page()
    {
        return view('Admin.master_data');
    }

    public function view_reprinting_documents_page ()
    {
        return view('Admin.reprinting_docs');
    }

    public function view_irregularity_create_page()
    {
        return view('Admin.parts_with_irreg_create');
    }

    public function view_irregularity_update_page()
    {
        return view('Admin.parts_with_irreg_update');
    }

    public function view_irregularity_print_page()
    {
        return view('Admin.parts_with_irreg_print');
    }

    public function view_leadtime_data_page()
    {
        return view('Admin.leadtime_data');
    }

    public function view_monitoring_report_page()
    {
        return view('Admin.monitoring_report');
    }

    public function view_parts_status_page()
    {
        return view('Admin.parts_status');
    }

    public function view_delivery_data_page()
    {
        return view('Admin.delivery_data');
    }

    public function view_checking()
    {
        return view('Transactions.checking');
    }

    public function view_palletizing()
    {
        return view('Transactions.palletizing');
    }

    public function update_delivery()
    {
        return view('Transactions.update_delivery');
    }

    public function receiving()
    {
        return view('Transactions.receiving');
    }

    public function view_users()
    {
        return view('Admin.Managements.user_management');
    }

    public function view_leadtime_report()
    {
        return view('Admin.Reports.leadtime_report');
    }

    public function view_pallet_report()
    {
        return view('Admin.Reports.pallet_report');
    }

    public function view_overall_graph_report()
    {
        return view('Admin.Reports.overall_graph_report');
    }

    public function view_forecast_page()
    {
        return view('Admin.forecast');
    }

    public function view_picker()
    {
        return view('Admin.picker');
    }
    public function leadtime_monitoring_mail()
    {
        return view('MAIL.leadtime_monitoring');
    }


}
