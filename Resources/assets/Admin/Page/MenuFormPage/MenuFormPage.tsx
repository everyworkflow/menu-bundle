/*
 * @copyright EveryWorkflow. All rights reserved.
 */

import React from 'react';
import DataFormPageComponent from '@EveryWorkflow/DataFormBundle/Component/DataFormPageComponent';
import FormMenuTabComponent from '@EveryWorkflow/DataFormBundle/Component/FormMenuTabComponent';
import { useParams } from 'react-router-dom';

const MenuFormPage = () => {
    const { code = '' }: any = useParams();

    return (
        <DataFormPageComponent
            title="Menu"
            getPath="/menu/{code}"
            savePath="/menu/{code}"
            primaryKey="code"
            primaryKeyLabel="Code"
            childrenBeforeHeader={code !== '' ?
                <FormMenuTabComponent tabData={[
                    {
                        label: 'Edit menu',
                        path: '/system/menu/' + code,
                    },
                    {
                        label: 'Menu builder',
                        path: '/system/menu/' + code + '/menu-builder',
                    }
                ]} /> : undefined}
        />
    );
};

export default MenuFormPage;
