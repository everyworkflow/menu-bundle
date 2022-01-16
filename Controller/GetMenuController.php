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

class GetMenuController extends AbstractController
{
    protected MenuRepositoryInterface $menuRepository;

    public function __construct(MenuRepositoryInterface $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }
    
    #[EwRoute(
        path: "menu/{code}",
        name: 'menu.view',
        methods: 'GET',
        permissions: 'menu.view',
        swagger: [
            'parameters' => [
                [
                    'name' => 'code',
                    'in' => 'path',
                    'default' => 'create',
                ]
            ]
        ]
    )]
    public function __invoke(string $code = 'default'): JsonResponse
    {
        $data = [];

        if ($code !== 'create') {
            $item = $this->menuRepository->findOne(['code' => $code]);
            if ($item) {
                $data['item'] = $item->toArray();
            }
        }

        $data['data_form'] = $this->menuRepository->getForm()->toArray();

        return new JsonResponse($data);
    }
}
