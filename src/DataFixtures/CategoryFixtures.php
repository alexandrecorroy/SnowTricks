<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 21/05/2018
 * Time: 10:24
 */

namespace App\DataFixtures;


use App\Entity\Category;
use App\Service\Slugger;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture implements DependentFixtureInterface
{

    private $slugger;

    public function __construct(Slugger $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $objectManager)
    {
        $groups = [
          'grabs',
          'rotations',
          'flips',
          'slides',
          'one foot tricks',
          'old school'
        ];

        foreach ($groups as $group) {
            $category = new Category();
            $category->setName(ucwords($group));
            $objectManager->persist($category);

            $this->addReference($this->slugger->slugify($group), $category);
        }

        $objectManager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }

}