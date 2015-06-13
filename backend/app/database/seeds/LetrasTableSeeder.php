<?php

class LetrasTableSeeder extends Seeder {

        private static $letras = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'ñ', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
	
        public function run()
	{
                foreach (self::$letras as $letra)
                {
                    DB::table('letras')->insert(array('letra' => $letra));
                }
	}

}