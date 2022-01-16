<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\MenuBundle\Controller;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\MenuBundle\Form\MenuItemFormInterface;
use EveryWorkflow\MenuBundle\Repository\MenuRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetMenuBuilderController extends AbstractController
{
    protected MenuRepositoryInterface $menuRepository;
    protected MenuItemFormInterface $menuItemForm;

    public function __construct(
        MenuRepositoryInterface $menuRepository,
        MenuItemFormInterface $menuItemForm
    ) {
        $this->menuRepository = $menuRepository;
        $this->menuItemForm = $menuItemForm;
    }

    #[EwRoute(
        path: "menu/{code}/menu-builder",
        name: 'menu.view.menu_builder',
        methods: 'GET',
        permissions: 'menu.view',
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
        $data = [];

        $item = $this->menuRepository->findOne(['code' => $code]);
        if ($item) {
            $data['item'] = $item->toArray();
        }

        $data['menu_builder']['data_form'] = $this->menuItemForm->toArray();

        return new JsonResponse($data);
    }
}
