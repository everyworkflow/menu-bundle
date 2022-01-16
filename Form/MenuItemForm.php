<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\MenuBundle\Form;

use EveryWorkflow\DataFormBundle\Field\Select\Option;
use EveryWorkflow\DataFormBundle\Model\Form;

class MenuItemForm extends Form implements MenuItemFormInterface
{
    public function getFields(): array
    {
        $fields = [
            $this->formFieldFactory->create([
                'label' => 'Item label',
                'name' => 'item_label',
                'field_type' => 'text_field',
                'is_required' => true,
            ]),
            $this->formFieldFactory->create([
                'label' => 'Item icon',
                'name' => 'item_icon',
                'field_type' => 'text_field',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Item path',
                'name' => 'item_path',
                'field_type' => 'text_field',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Item type',
                'name' => 'item_type',
                'field_type' => 'select_field',
                'options' => [
                    [
                        'key' => '',
                        'value' => 'Default - Path to a route',
                    ],
                    [
                        'key' => 'external_link',
                        'value' => 'External link',
                    ],
                    [
                        'key' => 'static_block_code',
                        'value' => 'Static block',
                    ],
                ]
            ]),
            $this->formFieldFactory->create([
                'label' => 'Item target',
                'name' => 'item_target',
                'field_type' => 'select_field',
                'options' => [
                    [
                        'key' => '',
                        'value' => 'Default',
                    ],
                    [
                        'key' => '_blank',
                        'value' => 'Blank - Opens in a new window or tab',
                    ],
                    [
                        'key' => '_self',
                        'value' => 'Self - Opens in the same frame as it was clicked (default)',
                    ],
                    [
                        'key' => '_parent',
                        'value' => 'Parent - Opens in the parent frame',
                    ],
                    [
                        'key' => '_top',
                        'value' => 'Top - Opens in the named iframe',
                    ],
                ],
            ]),
            $this->formFieldFactory->create([
                'label' => 'Item permission',
                'name' => 'item_permission',
                'field_type' => 'text_field',
            ]),
        ];

        return array_merge($fields, parent::getFields());
    }
}
