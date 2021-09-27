<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            array(1,'Administrador'),
            array(2,'Estandar'),
            array(3,'Invitado'),
        ];
        /**
         * Verificar si Existen
         */
        DB::table('role')->truncate();
        foreach ($items as $values => $key){
            $r = $values+1;
            DB::table('role')
                ->where('name','=',$values)
                ->insert([
                    'id' => $key[0],
                    'name' => ucwords($key[1]),
                    'created_at'=> new DateTime(),
                ]);
        }
    }
}
