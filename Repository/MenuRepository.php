<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\MenuBundle\Repository;

use EveryWorkflow\EavBundle\Repository\BaseEntityRepository;
use EveryWorkflow\EavBundle\Support\Attribute\EntityRepositoryAttribute;
use EveryWorkflow\MenuBundle\Entity\MenuEnity;

#[EntityRepositoryAttribute(
    documentClass: MenuEnity::class,
    primaryKey: 'code',
    entityCode: 'menu'
)]
class MenuRepository extends BaseEntityRepository implements MenuRepositoryInterface
{
    // Something
}
