/*
 * @copyright EveryWorkflow. All rights reserved.
 */

import { lazy } from "react";

const MenuListPage = lazy(() => import("@EveryWorkflow/MenuBundle/Admin/Page/MenuListPage"));
const MenuFormPage = lazy(() => import("@EveryWorkflow/MenuBundle/Admin/Page/MenuFormPage"));
const MenuBuilderPage = lazy(() => import("@EveryWorkflow/MenuBundle/Admin/Page/MenuBuilderPage"));

export const MenuRoutes = [
    {
        path: '/system/menu',
        exact: true,
        component: MenuListPage
    },
    {
        path: '/system/menu/create',
        exact: true,
        component: MenuFormPage
    },
    {
        path: '/system/menu/:code',
        exact: true,
        component: MenuFormPage
    },
    {
        path: '/system/menu/:code/menu-builder',
        exact: true,
        component: MenuBuilderPage
    },
];
