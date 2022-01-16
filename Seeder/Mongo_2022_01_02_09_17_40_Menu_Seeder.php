<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\MenuBundle\Seeder;

use EveryWorkflow\MenuBundle\Repository\MenuRepositoryInterface;
use EveryWorkflow\MongoBundle\Support\SeederInterface;

class Mongo_2022_01_02_09_17_40_Menu_Seeder implements SeederInterface
{
    protected MenuRepositoryInterface $menuRepository;

    public function __construct(
        MenuRepositoryInterface $menuRepository
    ) {
        $this->menuRepository = $menuRepository;
    }

    public function seed(): bool
    {
        $menuBuilderData = json_decode('[
            {
              "item_label": "Solutions",
              "item_path": "/solutions",
              "children": [
                {
                  "item_label": "Progressive web application",
                  "item_icon": "",
                  "item_path": "/pwa"
                }
              ]
            },
            {
              "item_label": "Resources",
              "item_path": "/resources",
              "children": [
                {
                  "item_label": "User documentation",
                  "item_path": "/user-documentation"
                },
                {
                  "item_label": "Api documentation",
                  "item_path": "/api-documentation"
                },
                {
                  "item_label": "Frontend development",
                  "item_path": "/frontend-development"
                },
                {
                  "item_label": "Backend development",
                  "item_path": "/backend-development"
                },
                {
                  "item_label": "Research and development",
                  "item_path": "/research-and-development"
                }
              ]
            },
            {
              "item_label": "Blog",
              "item_path": "/blog"
            },
            {
              "item_label": "About",
              "item_path": "/about"
            },
            {
              "item_label": "Contact",
              "item_path": "/contact"
            },
            {
              "item_label": "Examples",
              "item_path": "/examples",
              "children": [
                {
                  "item_label": "Privacy policy",
                  "item_path": "/privacy-policy"
                },
                {
                  "item_label": "Terms of use",
                  "item_path": "/terms-of-use"
                },
                {
                  "item_label": "Data Form block",
                  "item_path": "/examples/data-form-block"
                },
                {
                  "item_label": "Data Form - admin panel page",
                  "item_path": "/examples/data-form"
                },
                {
                  "item_label": "Page builder edit page",
                  "item_path": "/examples/page-builder-edit-page"
                }
              ]
            }
          ]', true);

        $frontendMenu = $this->menuRepository->create([
            'name' => 'Frontend menu',
            'code' => 'frontend_menu',
            'status' => 'enable',
            'menu_builder_data' => $menuBuilderData,
        ]);
        $this->menuRepository->saveOne($frontendMenu);

        return self::SUCCESS;
    }

    public function rollback(): bool
    {
        $this->menuRepository->deleteByFilter(['code' => 'frontend_menu']);

        return self::SUCCESS;
    }
}
