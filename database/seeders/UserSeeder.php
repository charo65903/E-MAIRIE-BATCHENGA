<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Comptes de démonstration — mot de passe unique "password" pour tous.
     * updateOrCreate (clé = email) permet de relancer ce seeder sans erreur
     * de contrainte unique.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@e-mairie-batchenga.cm'],
            [
                'nom' => 'Ekani',
                'prenom' => 'Paul',
                'telephone' => '677000001',
                'password' => 'password',
                'role' => 'administrateur',
                'actif' => true,
            ]
        );

        $agents = [
            ['nom' => 'Mballa', 'prenom' => 'Suzanne', 'email' => 'agent.etatcivil@e-mairie-batchenga.cm', 'telephone' => '677000002'],
            ['nom' => 'Ateba', 'prenom' => 'Joseph', 'email' => 'agent.secretariat@e-mairie-batchenga.cm', 'telephone' => '677000003'],
            ['nom' => 'Nguema', 'prenom' => 'Christelle', 'email' => 'agent.recette@e-mairie-batchenga.cm', 'telephone' => '677000004'],
        ];

        foreach ($agents as $agent) {
            User::updateOrCreate(
                ['email' => $agent['email']],
                [
                    'nom' => $agent['nom'],
                    'prenom' => $agent['prenom'],
                    'telephone' => $agent['telephone'],
                    'password' => 'password',
                    'role' => 'agent',
                    'actif' => true,
                ]
            );
        }

        $citoyens = [
            ['nom' => 'Fouda', 'prenom' => 'Marie', 'email' => 'marie.fouda@example.com', 'telephone' => '699000001'],
            ['nom' => 'Biya', 'prenom' => 'Jean', 'email' => 'jean.biya@example.com', 'telephone' => '699000002'],
            ['nom' => 'Owona', 'prenom' => 'Chantal', 'email' => 'chantal.owona@example.com', 'telephone' => '699000003'],
            ['nom' => 'Essomba', 'prenom' => 'Pierre', 'email' => 'pierre.essomba@example.com', 'telephone' => '699000004'],
            ['nom' => 'Ngo Bell', 'prenom' => 'Sylvie', 'email' => 'sylvie.ngobell@example.com', 'telephone' => '699000005'],
            ['nom' => 'Atangana', 'prenom' => 'Robert', 'email' => 'robert.atangana@example.com', 'telephone' => '699000006', 'actif' => false],
        ];

        foreach ($citoyens as $citoyen) {
            User::updateOrCreate(
                ['email' => $citoyen['email']],
                [
                    'nom' => $citoyen['nom'],
                    'prenom' => $citoyen['prenom'],
                    'telephone' => $citoyen['telephone'],
                    'password' => 'password',
                    'role' => 'citoyen',
                    'actif' => $citoyen['actif'] ?? true,
                ]
            );
        }
    }
}
