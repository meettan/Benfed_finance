<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SendReport extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('email');
        $this->load->helper(['file', 'url']);
    }

    public function index() {
        $this->load->view('send_email_view');
    }
        // File inside "application/uploads/"
        public function sendmail(){
        $filePath = APPPATH . 'uploads/financial_report_oct_2025.pdf';
        $logFile  = APPPATH . 'logs/email_log.txt';

        if (!file_exists($filePath)) {
            echo "❌ File not found: $filePath";
            return;
        }

        // Email setup
        $this->email->from('rajasaha.here@gmail.com', 'Finance System');
        $this->email->to('raja.saha@synergicsoftek.com');
        $this->email->subject('Financial Report - October 2025');
        $this->email->message('<p>Dear Team,<br><br>Please find attached the financial report for October 2025.</p>');
        $this->email->attach($filePath);

        // Try to send email
        if ($this->email->send()) {
            $result = "✅ Report emailed successfully!";
        } else {
            $result = "❌ Failed to send email:\n" . $this->email->print_debugger(['headers']);
        }

        // Log result in application/logs/email_log.txt
        $logEntry = "=============================\n"
                  . date('Y-m-d H:i:s') . "\n"
                  . $result . "\n\n";
        file_put_contents($logFile, $logEntry, FILE_APPEND);

        // Show on screen too
        echo nl2br($result);
    }
}
