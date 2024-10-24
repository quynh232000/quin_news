<?php

namespace App\Console\Commands;

use App\Models\denynews;
use App\Models\News;
use Exception;
use Http;
use Illuminate\Console\Command;

class CheckTextComand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:text';
    // * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check bad words';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $news_pendings = News::where('status', 'pending')->get();
            if ($news_pendings->count() > 0) {
                foreach ($news_pendings as $news) {
                    $text = $news->title . ' ' . $news->subtitle;
                    $response = $this->api_check($text);
                    $bad_words = json_decode($response);
                    // json_decode
                    if ($bad_words->bad_words_total > 0) {
                        $news->status = 'deny';
                        denynews::updateOrCreate(
                            ['news_id' => $news->id],
                            [
                                'news_id' => $news->id,
                                'bad_words_total' => $bad_words->bad_words_total,
                                'bad_words_list' => json_encode($bad_words->bad_words_list)
                            ]
                        );
                        $news->save();
                    } else {
                        $check_deny = denynews::where(['news_id' => $news->id]);
                        if ($check_deny) {
                            $check_deny->delete();
                        }
                        $news->status = 'active';
                        $news->save();
                    }
                }
                $this->info('Check text successfully for (' . $news_pendings->count() . ') news!');
            } else {
                $this->info('No news pending to check text!');
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
    protected function api_check($text)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'text/plain',
            'apikey' => 'TwUECG6wXc4f0n0xxb4BS7vR2kekHq1U'
        ])->post('https://api.apilayer.com/bad_words?censor_character=*', [
                    'body' => $text
                ]);
        return $response->body();
    }
}
