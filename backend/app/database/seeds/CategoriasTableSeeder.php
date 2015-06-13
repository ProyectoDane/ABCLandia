<?php

class CategoriasTableSeeder extends Seeder {

	public function run()
	{
                DB::statement("
                        INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `deleted_at`, `created_at`, `updated_at`, `maestro_id`) VALUES 
                        (0, 'Categoría inicial', 'Categoría inicial provista por Gelemer', NULL, NOW(), NOW(), 1);
                ");
	}

}