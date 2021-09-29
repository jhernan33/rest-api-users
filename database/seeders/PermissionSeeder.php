<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            array(1,'Crear','Permite agregar un Registro a la Tabla'),
            array(2,'Modificar','Permite realizar un cambio en el Registro de la Tabla'),
            array(3,'Eliminar','Permite borrar un Registro de la Tabla'),
            array(4,'Listar','Permite Listar todo los Registro de la Tabla'),
            array(5,'Ver Detalle','Permite Listar un Registro de la Tabla'),
        ];
        /**
         * Verificar si Existen
         */
        DB::table('permission')->truncate();
        foreach ($items as $values => $key){
            $r = $values+1;
            DB::table('permission')
                ->where('name','=',$values)
                ->insert([
                    'id' => $key[0],
                    'name' => ucwords($key[1]),
                    'description'=> ucwords($key[2]),
                    'created_at'=> new DateTime(),
                ]);
        }
        /**
         * Actualizar la secuencia de la tabla
         */
        DB::select("select setval('permission_id_seq',5);");
    }
}
