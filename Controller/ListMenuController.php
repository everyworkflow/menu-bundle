<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\MenuBundle\Controller;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\MenuBundle\DataGrid\MenuDataGridInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ListMenuController extends AbstractController
{
    protected MenuDataGridInterface $menuDataGrid;

    public function __construct(MenuDataGridInterface $menuDataGrid)
    {
        $this->menuDataGrid = $menuDataGrid;
    }

    #[EwRoute(
        path: "menu",
        name: 'menu',
        priority: 10,
        methods: 'GET',
        permissions: 'menu.list',
        swagger: true
    )]
    public function __invoke(Request $request): JsonResponse
    {
        $dataGrid = $this->menuDataGrid->setFromRequest($request);
        return new JsonResponse($dataGrid->toArray());
    }
}
