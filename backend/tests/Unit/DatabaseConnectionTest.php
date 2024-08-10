<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DatabaseConnectionTest extends TestCase
{
    public function test_database_connection()
    {
        $this->assertEquals('testing', config('database.default'));
        $this->assertEquals('osecours_test', config('database.connections.testing.database'));

        // Tenter une requête simple
        $result = DB::select('SELECT 1 as test');
        $this->assertEquals(1, $result[0]->test);

        // Vérifier le nom de la base de données actuelle
        $dbName = DB::select('SELECT current_database() as db_name')[0]->db_name;
        $this->assertEquals('osecours_test', $dbName);
    }
}
