<?php

namespace App\Console\Commands;

use App\Mail\Distribution;
use App\Models\Email;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending emails to customers';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $mails = Email::where('sent_at', null)->take(15)->get();
//        Mail::to('dkhorosh@yandex.com')->send(new Distribution());die;
        if (!$mails->isEmpty()) {
            foreach ($mails as $mail) {
                sleep(20);
                Mail::to($mail->email)->send(new Distribution());
                Log::notice('email sent to ' . $mail->email);
                $mail->sent_at = now();
                $mail->save();
            }
        }

        return Command::SUCCESS;
    }
}
