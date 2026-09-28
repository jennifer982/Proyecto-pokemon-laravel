<?php

namespace Database\Seeders;

use App\Models\Habitat;
use App\Models\Pokemon;
use App\Models\Type;
use Illuminate\Database\Seeder;

class PokemonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pokemons = [
            [
                'name' => 'Bulbasaur',
                'description' => 'Puede pasar días sin comer gracias al bulbo en su lomo, que almacena energía.',
                'habitat' => 'Grassland',
                'types' => ['Grass', 'Poison'],
                'attack' => 49, 'defense' => 49, 'hp' => 45,
            ],
            [
                'name' => 'Charmander',
                'description' => 'La llama en la punta de su cola indica su estado de ánimo y se apaga si está débil.',
                'habitat' => 'Mountain',
                'types' => ['Fire'],
                'attack' => 52, 'defense' => 43, 'hp' => 39,
            ],
            [
                'name' => 'Squirtle',
                'description' => 'Se oculta en su caparazón para protegerse y luego ataca lanzando agua a presión.',
                'habitat' => 'Waters-edge',
                'types' => ['Water'],
                'attack' => 48, 'defense' => 65, 'hp' => 44,
            ],
            [
                'name' => 'Pikachu',
                'description' => 'Almacena electricidad en sus mejillas y la libera cuando se siente amenazado.',
                'habitat' => 'Forest',
                'types' => ['Electric'],
                'attack' => 55, 'defense' => 40, 'hp' => 35,
            ],
            [
                'name' => 'Eevee',
                'description' => 'Su estructura genética inestable le permite evolucionar en múltiples formas distintas.',
                'habitat' => 'Urban',
                'types' => ['Normal'],
                'attack' => 55, 'defense' => 50, 'hp' => 55,
            ],
            [
                'name' => 'Gengar',
                'description' => 'Se dice que aparece de entre las sombras para robar la vida de quien lo ve.',
                'habitat' => 'Rare',
                'types' => ['Ghost', 'Poison'],
                'attack' => 65, 'defense' => 60, 'hp' => 60,
            ],
            [
                'name' => 'Onix',
                'description' => 'Su cuerpo de roca se vuelve más duro y brillante conforme envejece.',
                'habitat' => 'Cave',
                'types' => ['Rock', 'Ground'],
                'attack' => 45, 'defense' => 160, 'hp' => 35,
            ],
            [
                'name' => 'Jigglypuff',
                'description' => 'Canta una melodía hipnótica que hace dormir a quien la escucha.',
                'habitat' => 'Grassland',
                'types' => ['Normal', 'Fairy'],
                'attack' => 45, 'defense' => 20, 'hp' => 115,
            ],
            [
                'name' => 'Psyduck',
                'description' => 'El constante dolor de cabeza que sufre libera un poder psíquico misterioso.',
                'habitat' => 'Waters-edge',
                'types' => ['Water'],
                'attack' => 52, 'defense' => 48, 'hp' => 50,
            ],
            [
                'name' => 'Machop',
                'description' => 'Entrena su cuerpo musculoso a diario para poder levantar objetos enormes.',
                'habitat' => 'Mountain',
                'types' => ['Fighting'],
                'attack' => 80, 'defense' => 50, 'hp' => 70,
            ],
            [
                'name' => 'Abra',
                'description' => 'Pasa 18 horas al día durmiendo mientras usa telepatía para percibir peligros.',
                'habitat' => 'Urban',
                'types' => ['Psychic'],
                'attack' => 20, 'defense' => 15, 'hp' => 25,
            ],
            [
                'name' => 'Snorlax',
                'description' => 'Duerme la mayor parte del día y solo se mueve para comer enormes cantidades de comida.',
                'habitat' => 'Grassland',
                'types' => ['Normal'],
                'attack' => 110, 'defense' => 65, 'hp' => 160,
            ],
        ];

        foreach ($pokemons as $data) {
            $habitat = Habitat::firstOrCreate(['name' => $data['habitat']]);

            $pokemon = Pokemon::updateOrCreate(
                ['name' => $data['name']],
                [
                    'description' => $data['description'],
                    'habitat_id' => $habitat->id,
                    'attack' => $data['attack'],
                    'defense' => $data['defense'],
                    'hp' => $data['hp'],
                ]
            );

            $typeIds = collect($data['types'])->map(
                fn (string $type) => Type::firstOrCreate(['name' => $type])->id
            );

            $pokemon->types()->sync($typeIds);
        }
    }
}
