<?php

namespace App\Controller;

use App\Entity\PartnerFulfillmentPeriod;
use App\Transformers\ListOptionTransformer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PartnerFulfillmentPeriodController
 * @package App\Controllers
 *
 * @Route(path="/api/partners/fulfillment-periods")
 * @IsGranted({
 *     "ROLE_PARTNER_VIEW_ALL",
 *     "ROLE_PARTNER_EDIT_ALL",
 *     "ROLE_PARTNER_MANAGE_OWN"
 * })
 *
 */
class PartnerFulfillmentPeriodController extends ListOptionController
{
    protected $defaultEntityName = PartnerFulfillmentPeriod::class;


    protected function getListOptionEntityInstance()
    {
        return new PartnerFulfillmentPeriod();
    }

    protected function getDefaultTransformer()
    {
        return new ListOptionTransformer();
    }
}
