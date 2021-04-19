<?php

namespace App\Controller;

use App\Entity\ZipCounty;
use App\Transformers\ZipCountyTransformer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/api/zip-county")
 */
class ZipCountyController extends BaseController
{
    /**
     * Get a list of matching zip codes/counties
     *
     * @Route(path="/", methods={"GET"})
     * @IsGranted({"ROLE_USER"})
     *
     * @return JsonResponse
     */
    public function index(Request $request, string $query = null)
    {
        /** @var ZipCounty[] $zips */
        $zips = $this->getRepository(ZipCounty::class)->findAllInConstraints();

        return $this->serialize($request, $zips);
    }

    protected function getDefaultTransformer()
    {
        return new ZipCountyTransformer();
    }
}
