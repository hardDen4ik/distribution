<?php

namespace App\Console\Commands;

use App\Models\Email;
use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class UploadEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uploads emails from .xlsx file from root directory of project';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $reader = new Xlsx();
        $spreadsheet = $reader->load(base_path('mails.xlsx')); // тут наш файл с таблицей Excel
        $worksheet = $spreadsheet->setActiveSheetIndex(0);
        $highestRow = $worksheet->getHighestRow();
        $highestCol = $worksheet->getHighestColumn();

// данной строкой мы заносим все строки (начиная с A1) в наш массив
        $infoByTableReviews = $worksheet->rangeToArray("A1:$highestCol$highestRow", null, false, false, false);
        $i = 0;
        $formatted = [];
        if (!empty($infoByTableReviews)) {
            foreach ($infoByTableReviews as $item) {
                if ($i == 0) {
                    $i++;
                    continue;
                }
                $rec = trim($item[0]);
                if ($rec != null) {
                    $formatted[] = $rec;
                }
            }
            $formatted = array_unique($formatted);
            foreach ($formatted as $item) {
                $mail = new Email();
                $mail->email = $item;
//            $mail->sent_at = now();
                $mail->save();
            }
        }

        return Command::SUCCESS;
    }
}
