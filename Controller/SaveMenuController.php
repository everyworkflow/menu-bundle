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
use Symfony\Component\HttpFoundation\Request;

class SaveMenuController extends AbstractController
{
    protected MenuRepositoryInterface $menuRepository;

    public function __construct(MenuRepositoryInterface $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    #[EwRoute(
        path: "menu/{code}",
        name: 'menu.save',
        methods: 'POST',
        permissions: 'menu.save',
        swagger: [
            'parameters' => [
                [
                    'name' => 'code',
                    'in' => 'path',
                    'default' => 'create',
                ]
            ],
            'requestBody' => [
                'content' => [
                    'application/json' => []
                ]
            ]
        ]
    )]
    public function __invoke(Request $request, string $code = 'create'): JsonResponse
    {
        $submitData = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        if ('create' === $code) {
            $item = $this->menuRepository->create($submitData);
        } else {
            $item = $this->menuRepository->findOne(['code' => $code]);
            foreach ($submitData as $key => $val) {
                $item->setData($key, $val);
            }
        }

        $item = $this->menuRepository->saveOne($item);

        return new JsonResponse([
            'detail' => 'Successfully saved changes.',
            'item' => $item->toArray(),
        ]);
    }
}
