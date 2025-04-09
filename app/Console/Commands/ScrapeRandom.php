<?php

namespace App\Console\Commands;

use App\Models\Profile;
use Facebook\WebDriver\Exception\TimeoutException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class ScrapeRandom extends Command
{
    const LIMIT = 100;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:random';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape '.self::LIMIT.' users from OnlyFans from random number';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $username = generateNineDigitNumber(5);
        $this->info("Scraping likes for: {$username}");

        $this->browse(function ($browser) use ($username) {
            for ($i = 0; $i < self::LIMIT; $i++) {
                $username = $username + $i;
                $url = "https://onlyfans.com/{$username}";
                $browser->visit($url);

                try {
                    $browser->waitFor('.l-profile-container', 2);
                } catch (TimeoutException $e) {
                    $this->error("profile {$username} not found: " . $e->getMessage());
                    continue;
                }

                try {
                    $inputData = [
                        'username' => ltrim(optional($browser->element('.g-user-realname__wrapper.m-nowrap-text'))->getText(), '@'),
                        'name' => optional($browser->element('.b-username .g-user-name'))->getText(),
                        'bio' => optional($browser->element('div.b-user-info__text'))->getText(),
                        'likes' => normalizeCount(
                            optional($browser->element('span[aria-label="Likes"] .b-profile__sections__count'))->getText() ?? '0'
                        ),
                    ];
                } catch (\Exception $e) {
                    $this->error("error extract data from user {$username}: " . $e->getMessage());
                    continue;
                }

                $validator = Validator::make($inputData, [
                    'username' => 'required|string|max:255',
                    'name' => 'nullable|string|max:255',
                    'bio' => 'nullable|string',
                    'likes' => 'nullable|integer|min:0',
                ]);

                if ($validator->fails()) {
                    $this->error("validation failed: " . implode(' | ', $validator->errors()->all()));
                    continue;
                }

                Profile::updateOrCreate(['username' => $inputData['username']],
                    [
                        'name' => $inputData['name'] ?? null,
                        'bio' => $inputData['bio'] ?? null,
                        'likes' => $inputData['likes'] ?? 0,
                    ]
                );
                $this->info("{$inputData['username']} profile saved!");
            }
        });

        $this->info("Done!");
    }
}
