<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\MenuBundle\Controller;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\MenuBundle\Repository\MenuRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteMenuController extends AbstractController
{
    protected MenuRepositoryInterface $menuRepository;

    public function __construct(MenuRepositoryInterface $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    #[EwRoute(
        path: "menu/{code}",
        name: 'menu.delete',
        methods: 'DELETE',
        permissions: 'menu.delete',
        swagger: [
            'parameters' => [
                [
                    'name' => 'code',
                    'in' => 'path',
                ]
            ]
        ]
    )]
    public function __invoke(string $code): JsonResponse
    {
        try {
            $this->menuRepository->deleteOneByFilter(['code' => $code]);
            return new JsonResponse(['detail' => 'Menu with code: ' . $code . ' deleted successfully.']);
        } catch (\Exception $e) {
            return new JsonResponse(['detail' => $e->getMessage()], 500);
        }
    }
}
