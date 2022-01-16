<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use EveryWorkflow\DataGridBundle\Model\Collection\RepositorySource;
use EveryWorkflow\DataGridBundle\Model\DataGridConfig;
use EveryWorkflow\MenuBundle\DataGrid\MenuDataGrid;
use EveryWorkflow\MenuBundle\Repository\MenuRepository;
use Symfony\Component\DependencyInjection\Loader\Configurator\DefaultsConfigurator;

return function (ContainerConfigurator $configurator) {
    /** @var DefaultsConfigurator $services */
    $services = $configurator
        ->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();

    $services
        ->load('EveryWorkflow\\MenuBundle\\', '../../*')
        ->exclude('../../{DependencyInjection,Resources,Support,Tests}');

    $services->set('ew_menu_grid_config', DataGridConfig::class);
    $services->set('ew_menu_grid_source', RepositorySource::class)
        ->arg('$baseRepository', service(MenuRepository::class))
        ->arg('$dataGridConfig', service('ew_menu_grid_config'));
    $services->set(MenuDataGrid::class)
        ->arg('$source', service('ew_menu_grid_source'))
        ->arg('$dataGridConfig', service('ew_menu_grid_config'));
};
