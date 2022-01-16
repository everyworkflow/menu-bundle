<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\MenuBundle\DataGrid;

use EveryWorkflow\CoreBundle\Model\DataObjectFactoryInterface;
use EveryWorkflow\CoreBundle\Model\DataObjectInterface;
use EveryWorkflow\DataFormBundle\Model\FormInterface;
use EveryWorkflow\DataGridBundle\BulkAction\ButtonBulkAction;
use EveryWorkflow\DataGridBundle\Factory\ActionFactoryInterface;
use EveryWorkflow\DataGridBundle\HeaderAction\ButtonHeaderAction;
use EveryWorkflow\DataGridBundle\Model\Collection\ArraySourceInterface;
use EveryWorkflow\DataGridBundle\Model\DataGrid;
use EveryWorkflow\DataGridBundle\Model\DataGridConfigInterface;
use EveryWorkflow\DataGridBundle\RowAction\ButtonRowAction;
use EveryWorkflow\MenuBundle\Repository\MenuRepositoryInterface;

class MenuDataGrid extends DataGrid implements MenuDataGridInterface
{
    protected DataObjectFactoryInterface $dataObjectFactory;
    protected MenuRepositoryInterface $menuRepository;
    protected ActionFactoryInterface $actionFactory;

    public function __construct(
        DataObjectInterface $dataObject,
        DataGridConfigInterface $dataGridConfig,
        FormInterface $form,
        ArraySourceInterface $source,
        DataObjectFactoryInterface $dataObjectFactory,
        MenuRepositoryInterface $menuRepository,
        ActionFactoryInterface $actionFactory,
    ) {
        parent::__construct($dataObject, $dataGridConfig, $form, $source);
        $this->dataObjectFactory = $dataObjectFactory;
        $this->menuRepository = $menuRepository;
        $this->actionFactory = $actionFactory;
    }

    public function getConfig(): DataGridConfigInterface
    {
        $config = parent::getConfig();

        $allColumns = ['_id'];
        foreach ($this->menuRepository->getAttributes() as $attribute) {
            if ($attribute->isUsedInGrid() && !isset($allColumns[$attribute->getCode()])) {
                $allColumns[] = $attribute->getCode();
            }
        }
        foreach (['status', 'created_at', 'updated_at'] as $item) {
            if (!isset($allColumns[$item])) {
                $allColumns[] = $item;
            }
        }

        $config->setIsFilterEnabled(true)
            ->setIsColumnSettingEnabled(true)
            ->setActiveColumns($allColumns)
            ->setSortableColumns($allColumns)
            ->setFilterableColumns($allColumns);

        $config->setHeaderActions([
            $this->actionFactory->create(ButtonHeaderAction::class, [
                'button_path' => '/system/menu/create',
                'button_label' => 'Create new',
                'button_type' => 'primary',
            ]),
        ]);

        $config->setRowActions([
            $this->actionFactory->create(ButtonRowAction::class, [
                'button_path' => '/system/menu/{code}/menu-builder',
                'button_label' => 'Menu builder',
                'button_type' => 'primary',
            ]),
            $this->actionFactory->create(ButtonRowAction::class, [
                'button_path' => '/system/menu/{code}',
                'button_label' => 'Edit menu',
                'button_type' => 'primary',
            ]),
            $this->actionFactory->create(ButtonRowAction::class, [
                'button_path' => '/menu/{code}',
                'button_label' => 'Delete',
                'button_type' => 'primary',
                'path_type' => ButtonRowAction::PATH_TYPE_DELETE_CALL,
                'is_danger' => true,
                'is_confirm' => true,
                'confirm_message' => 'Are you sure, you want to delete this item?',
            ]),
        ]);

        $config->setBulkActions([
            $this->actionFactory->create(ButtonBulkAction::class, [
                'button_label' => 'Enable',
                'button_path' => '/menu/bulk-action/enable',
                'button_type' => 'default',
                'path_type' => ButtonBulkAction::PATH_TYPE_POST_CALL,
            ]),
            $this->actionFactory->create(ButtonBulkAction::class, [
                'button_label' => 'Disable',
                'button_path' => '/menu/bulk-action/disable',
                'button_type' => 'default',
                'path_type' => ButtonBulkAction::PATH_TYPE_POST_CALL,
            ]),
        ]);

        return $config;
    }

    public function getForm(): FormInterface
    {
        return $this->menuRepository->getForm();
    }
}
