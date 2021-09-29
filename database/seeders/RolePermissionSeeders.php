<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            //  Rol Administrador los Permisos
            array(1,1,1),
            array(2,1,2),
            array(3,1,3),
            array(4,1,4),
            array(5,1,5),
            // Rol Estandar los Permisos
            array(6,2,1),
            array(7,2,2),
            array(8,2,4),
            array(9,2,5),
            //  Rol Invitado los Permisos
            array(10,3,5),
        ];
        /**
         * Verificar si Existen
         */
        DB::table('role_permission')->truncate();
        foreach ($items as $values => $key){
            $r = $values+1;
            DB::table('role_permission')
                ->where('role_id','=',$key[1])
                ->where('permission_id','=',$key[2])
                ->insert([
                    'id' => $key[0],
                    'role_id' => $key[1],
                    'permission_id' => $key[2],
                    'created_at'=> new DateTime(),
                ]);
        }
        /**
         * Actualizar la secuencia de la tabla
         */
        DB::select("select setval('role_permission_id_seq',10);");
    }
}
