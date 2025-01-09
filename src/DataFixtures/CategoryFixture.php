<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Define the data to insert
        $now    = new \DateTime();
        $data   = [
            [
                'name' => 'Développement personnel',
                'description' => 'Livres axés sur le dépassement de soi, la discipline et l\'amélioration continue.',
            ],
            [
                'name' => 'Psychologie',
                'description' => 'Ouvrages pour comprendre et améliorer son fonctionnement mental, gérer le stress et les émotions.',
            ],
            [
                'name' => 'Spiritualité',
                'description' => 'Textes sur la méditation, la pleine conscience, la quête de sens et l\'épanouissement spirituel.',
            ],
            [
                'name' => 'Leadership et management',
                'description' => 'Livres pour développer ses compétences de leader, motiver une équipe et gérer des projets efficacement.',
            ],
            [
                'name' => 'Business',
                'description' => 'Ouvrages sur la création, la gestion et le développement d\'une entreprise.',
            ],
            [
                'name' => 'Communication',
                'description' => 'Textes pour améliorer ses interactions, développer l\'empathie et gérer les conflits.',
            ],
            [
                'name' => 'Finance',
                'description' => 'Livres pour apprendre à gérer ses finances, investir et atteindre l\'indépendance financière.',
            ],
            [
                'name' => 'Bien-être',
                'description' => 'Axé sur l\'amélioration du corps et de l\'esprit par la nutrition, le sport, et le sommeil.',
            ],
            [
                'name' => 'Créativité',
                'description' => 'Livres sur l\'expression de son potentiel créatif et l\'innovation dans différents domaines.',
            ],
            [
                'name' => 'Motivation',
                'description' => 'Ouvrages pour apprendre à surmonter les épreuves, rebondir et trouver de l\'inspiration.',
            ]
        ];


        // Iterate over the data and create entities
        foreach ($data as $item) {
            $category = new Category();
            $category->setName($item['name']);
            $category->setDescription($item['description']);
            $category->setCreatedAt($now);
            $category->setUpdatedAt($now);

            $manager->persist($category);
        }

        // Persist data to the database
        $manager->flush();
    }
}
