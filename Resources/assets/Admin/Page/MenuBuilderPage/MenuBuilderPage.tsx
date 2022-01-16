/*
 * @copyright EveryWorkflow. All rights reserved.
 */

import React, { useContext, useEffect, useState } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import PanelContext from "@EveryWorkflow/PanelBundle/Context/PanelContext";
import DataFormInterface from "@EveryWorkflow/DataFormBundle/Model/DataFormInterface";
import { ACTION_SET_PAGE_TITLE } from "@EveryWorkflow/PanelBundle/Reducer/PanelReducer";
import Remote from "@EveryWorkflow/PanelBundle/Service/Remote";
import PageHeaderComponent from "@EveryWorkflow/AdminPanelBundle/Component/PageHeaderComponent";
import BreadcrumbComponent from "@EveryWorkflow/AdminPanelBundle/Component/BreadcrumbComponent";
import AlertAction, { ALERT_TYPE_ERROR, ALERT_TYPE_SUCCESS } from "@EveryWorkflow/PanelBundle/Action/AlertAction";
import MenuEditorComponent from "@EveryWorkflow/MenuBundle/Component/MenuEditorComponent";
import { ACTION_HIDE_FOOTER, ACTION_SHOW_FOOTER } from '@EveryWorkflow/AdminPanelBundle/Reducer/AdminPanelReducer';
import AdminPanelContext from '@EveryWorkflow/AdminPanelBundle/Context/AdminPanelContext';
import FormMenuTabComponent from '@EveryWorkflow/DataFormBundle/Component/FormMenuTabComponent';
import Button from 'antd/lib/button';
import Space from 'antd/lib/space';
import Popconfirm from 'antd/lib/popconfirm';

const SUBMIT_SAVE_CHANGES = 'save_changes';
const SUBMIT_SAVE_CHANGES_AND_CONTINUE = 'save_changes_and_continue';

const MenuBuilderPage = () => {
    const { dispatch: panelDispatch } = useContext(PanelContext);
    const { dispatch: adminPanelDispatch } = useContext(AdminPanelContext);
    const { code = '' }: any = useParams();
    const navigate = useNavigate();
    const [menuItemFormData, setMenuItemFormData] = useState<DataFormInterface>();
    const [menuData, setMenuData] = useState<Array<any>>([]);
    let submitAction: string | undefined = undefined;

    useEffect(() => {
        panelDispatch({
            type: ACTION_SET_PAGE_TITLE,
            payload: 'Menu builder',
        });
        adminPanelDispatch({ type: ACTION_HIDE_FOOTER });

        const handleResponse = (response: any) => {
            if (response.item && response.item.menu_builder_data) {
                setMenuData(response.item.menu_builder_data);
            }
            if (response.menu_builder && response.menu_builder.data_form) {
                setMenuItemFormData(response.menu_builder.data_form);
            }
        };

        const fetchItem = async () => {
            try {
                const response: any = await Remote.get('/menu/' + code + '/menu-builder');
                handleResponse(response);
            } catch (error: any) {
                AlertAction({
                    description: error.message,
                    message: 'Fetch error',
                    type: ALERT_TYPE_ERROR,
                });
            }
        };

        fetchItem();

        return () => {
            adminPanelDispatch({ type: ACTION_SHOW_FOOTER });
        };
    }, [panelDispatch, code]);

    const onSubmit = async (submitData: any) => {
        const handlePostResponse = (response: any) => {
            AlertAction({
                description: response.detail,
                message: 'Form submit success',
                type: ALERT_TYPE_SUCCESS,
            });
            if (submitAction === SUBMIT_SAVE_CHANGES) {
                navigate(-1);
            }
        };

        try {
            const response = await Remote.post(
                '/menu/' + code + '/menu-builder',
                submitData
            );
            handlePostResponse(response);
        } catch (error: any) {
            AlertAction({
                description: error.message,
                message: 'Submit error',
                type: ALERT_TYPE_ERROR,
            });
        }
    };

    return (
        <>
            <FormMenuTabComponent tabData={[
                {
                    label: 'Edit menu',
                    path: '/system/menu/' + code,
                },
                {
                    label: 'Menu builder',
                    path: '/system/menu/' + code + '/menu-builder',
                }
            ]} />
            <PageHeaderComponent
                title={code !== '' ? `ID: ${code}` : undefined}
                right={(
                    <Space>
                        <Popconfirm
                            placement="bottomRight"
                            title="Are you sure you want to reset changes?"
                            onConfirm={() => {
                                (window as any).location.reload();
                            }}
                            okText="Yes"
                            cancelText="No">
                            <Button type="default">Reset</Button>
                        </Popconfirm>
                        <Button
                            onClick={() => {
                                submitAction = SUBMIT_SAVE_CHANGES;
                                onSubmit({ menu_builder_data: menuData });
                            }}
                            type="primary">Save changes</Button>
                        <Button
                            onClick={() => {
                                submitAction = SUBMIT_SAVE_CHANGES_AND_CONTINUE;
                                onSubmit({ menu_builder_data: menuData });
                            }}
                            type="primary">Save and continue</Button>
                    </Space>
                )}
            />
            <BreadcrumbComponent />
            {(code && menuItemFormData) && (
                <MenuEditorComponent
                    initialMenuData={menuData}
                    menuItemFormData={menuItemFormData}
                    onMenuDataChange={(menuData) => {
                        setMenuData(menuData);
                    }}
                />
            )}
        </>
    );
};

export default MenuBuilderPage;
