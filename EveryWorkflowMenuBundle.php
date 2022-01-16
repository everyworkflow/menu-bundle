<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\MenuBundle;

use EveryWorkflow\MenuBundle\DependencyInjection\MenuExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EveryWorkflowMenuBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new MenuExtension();
    }
}
