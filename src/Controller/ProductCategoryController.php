<?php

namespace App\Controller;

use App\Entity\ProductCategory;
use App\Entity\ProductCategoryRepository;
use App\Exception\UserInterfaceException;
use App\Transformers\ProductCategoryTransformer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PartnerDistributionMethodController
 * @package App\Controllers
 *
 * @Route(path="/api/product-categories")
 * @IsGranted({"ROLE_ADMIN"})
 *
 */
class ProductCategoryController extends ListOptionController
{
    protected $defaultEntityName = ProductCategory::class;


    protected function getListOptionEntityInstance()
    {
        return new ProductCategory();
    }

    protected function getDefaultTransformer()
    {
        return new ProductCategoryTransformer();
    }

    /**
     * Delete a ProductCategory
     * @Route(path="/{id<\d+>}", methods={"DELETE"})
     * @param int $id
     * @return JsonResponse
     * @throws UserInterfaceException
     */
    public function destroy(int $id): JsonResponse
    {
        /** @var ProductCategory $productCategory */
        $productCategory = $this->getListOption($id);

        /** @var ProductCategoryRepository $productCategoryRepository */
        $productCategoryRepository = $this->getRepository();

        if (!$productCategoryRepository->isCategoryEmpty($productCategory)) {
            throw new UserInterfaceException('Cannot delete a category which has related products');
        }

        return parent::destroy($id);
    }
}
