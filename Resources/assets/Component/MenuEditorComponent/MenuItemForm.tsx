/*
 * @copyright EveryWorkflow. All rights reserved.
 */

import React, { useEffect } from 'react';
import Form from 'antd/lib/form';
import Card from 'antd/lib/card';
import DataFormInterface from "@EveryWorkflow/DataFormBundle/Model/DataFormInterface";
import DataFormComponent from "@EveryWorkflow/DataFormBundle/Component/DataFormComponent";
import Button from 'antd/lib/button';
import Space from 'antd/lib/space';
import { FORM_TYPE_HORIZONTAL } from "@EveryWorkflow/DataFormBundle/Component/DataFormComponent/DataFormComponent";
import Popconfirm from 'antd/lib/popconfirm';

interface MenuItemFormProps {
    menuItemFormData?: DataFormInterface;
    insertConfig?: any;
    selectedMenuItem?: any;
    onSubmit?: (data: Array<any>) => void;
    onDelete?: (data: Array<any>) => void;
}

const MenuItemForm = ({ menuItemFormData, insertConfig, selectedMenuItem, onSubmit, onDelete }: MenuItemFormProps) => {
    const [form] = Form.useForm();

    useEffect(() => {
        if (menuItemFormData) {
            form?.resetFields();
            form?.setFieldsValue(selectedMenuItem);
        }
    }, [menuItemFormData, selectedMenuItem]);

    return (
        <>
            <Card
                className="app-container"
                title={((): string => {
                    if (selectedMenuItem) {
                        return 'Edit menu item: ' + selectedMenuItem.item_label;
                    }
                    if (insertConfig) {
                        return 'Add menu item ' + insertConfig.type + ' ' + insertConfig.node.title;
                    }
                    return 'Create menu item';
                })()}
                extra={(
                    <Space>
                        {selectedMenuItem && (
                            <Popconfirm
                                title={"Are you sure？"}
                                onConfirm={() => {
                                    if (onDelete) {
                                        onDelete(selectedMenuItem);
                                    }
                                }}
                                okText="Yes"
                                cancelText="No">
                                <Button danger={true} ghost={true}>Delete</Button>
                            </Popconfirm>
                        )}
                        <Button type="primary" ghost={true} onClick={() => {
                            form?.submit();
                        }}>Save item changes</Button>
                    </Space>
                )}
                style={{ marginBottom: 24 }}>
                {menuItemFormData && (
                    <DataFormComponent
                        form={form}
                        formData={menuItemFormData}
                        formType={FORM_TYPE_HORIZONTAL}
                        onSubmit={(data: any) => {
                            if (onSubmit) {
                                onSubmit(data);
                                form?.resetFields();
                            }
                        }}
                        labelCol={{ span: 8 }}
                        wrapperCol={{ span: 12 }}
                    />
                )}
            </Card>
        </>
    );
};

export default MenuItemForm;
