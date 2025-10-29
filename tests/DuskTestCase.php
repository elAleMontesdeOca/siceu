<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Laravel\Dusk\TestCase as BaseTestCase;

abstract class DuskTestCase extends BaseTestCase
{
    public static function prepare(): void
    {
        if (!static::runningInSail()) {
            static::startChromeDriver(['--port=50875']);
        }
    }

    protected function driver(): RemoteWebDriver
    {
        $options = new ChromeOptions();
        $options->addArguments([
            '--disable-gpu',
            '--headless=new',
            '--window-size=1920,1080',
            '--disable-search-engine-choice-screen',
            '--disable-smooth-scrolling',
        ]);

        $capabilities = DesiredCapabilities::chrome();
        $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);

        return RemoteWebDriver::create(
            env('DUSK_DRIVER_URL', 'http://127.0.0.1:50875'),
            $capabilities,
            10000,   // conexión inicial en ms
            180000   // timeout de sesión en ms
        );
    }

    protected function baseUrl(): string
    {
        return env('APP_URL', 'http://127.0.0.1:8000');
    }
}
