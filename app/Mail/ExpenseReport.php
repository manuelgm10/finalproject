<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Expense;

class ExpenseReport extends Mailable
{
    use Queueable, SerializesModels;
    
    public $expense;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Expense $expense)
    {
        $this->expense = $expense;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('contact@ampleadmin.com', 'ampleadmin')->view('emails.expense_report');
    }
}
