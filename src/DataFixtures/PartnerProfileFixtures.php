<?php

namespace App\DataFixtures;

use App\Entity\EAV\Attribute;
use App\Entity\EAV\PartnerProfileDefinition;
use App\Entity\PartnerProfile;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Partner;

class PartnerProfileFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [
            PartnerFixtures::class,
            PartnerProfileAttributeFixtures::class,
            ZipCountyFixtures::class,
        ];
    }

    public function loadData(ObjectManager $manager)
    {
        $partners = $manager->getRepository(Partner::class)->findAll();
        $definitions = $manager->getRepository(PartnerProfileDefinition::class)->findAll();

        foreach ($partners as $partner) {
            $profile = new PartnerProfile();
            $profile->setPartner($partner);

            foreach ($definitions as $definition) {
                $attribute = $definition->createAttribute();
                if ($definition->getType() === Attribute::UI_ZIPCODE) {
                    $attribute->setValue($this->getReference('zip_county.1'));
                } else {
                    $attribute->setValue($attribute->fixtureData());
                }
                $profile->addAttribute($attribute);
            }
            $manager->persist($profile);
        }

        $manager->flush();
    }
}
