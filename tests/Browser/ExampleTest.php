<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     */
//    public function testBasicExample(): void
//    {
//        $this->browse(function (Browser $browser) {
//            $browser->visit('https://onlyfans.com/veronicaperassotv')
//                    ->assertSee('Veronica Perasso');
//        });
//    }

//    public function scrapeUser(string $username)
//    {
//        $url = "https://onlyfans.com/{$username}";
//
//        $this->browse(function (Browser $browser) use ($url, $username) {
//            $browser->visit($url)
//                ->pause(2000);
//
//            $element = $browser->driver->findElement(
//                WebDriverBy::xpath('//span[@aria-label="Likes"]//div[contains(@class, "b-profile__sections__count")]')
//            );
//
//            $likes = $element->getText();
//
//            echo "\nUser '{$username}' has {$likes} likes.\n";
//        });
//    }

    public function scrapeUser(string $username)
    {
        $url = "https://onlyfans.com/{$username}";

        $this->browse(function (Browser $browser) use $ {
            $browser->visit('https://onlyfans.com/veronicaperassotv')
                ->pause(2000); // optional: wait for JS


            // Get the text inside the div
            $count = $browser->text('span[aria-label="Likes"] .b-profile__sections__count');

            echo "Count: {$count}\n";

            $content = $browser->driver->getPageSource();

            // Print to console or dump it
//            echo $content;

            // Or get specific elements
//            $text = $browser->text('body'); // or any selector
//            echo $text;
        });
    }
}
