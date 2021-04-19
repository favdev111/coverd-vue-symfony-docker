<?php

namespace App\Controller;

use App\Entity\PartnerDistributionMethod;
use App\Transformers\ListOptionTransformer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PartnerDistributionMethodController
 * @package App\Controllers
 *
 * @Route(path="/api/partners/distribution-methods")
 * @IsGranted({
 *     "ROLE_PARTNER_VIEW_ALL",
 *     "ROLE_PARTNER_EDIT_ALL",
 *     "ROLE_PARTNER_MANAGE_OWN"
 * })
 *
 */
class PartnerDistributionMethodController extends ListOptionController
{
    protected $defaultEntityName = PartnerDistributionMethod::class;


    protected function getListOptionEntityInstance()
    {
        return new PartnerDistributionMethod();
    }

    protected function getDefaultTransformer()
    {
        return new ListOptionTransformer();
    }
}
