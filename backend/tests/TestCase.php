<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Config;

abstract class TestCase extends BaseTestCase
{
    //    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();

        // Forcer l'utilisation de la connexion de test
        Config::set('database.default', 'testing');

        // Vérifier que nous utilisons bien la bonne base de données
        $this->assertEquals('osecours_test', Config::get('database.connections.testing.database'));
    }
}
