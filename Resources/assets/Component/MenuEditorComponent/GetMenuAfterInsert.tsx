/*
 * @copyright EveryWorkflow. All rights reserved.
 */

export const DROP_TYPE_BEFORE = 'before'; //default
export const DROP_TYPE_AFTER = 'after';
export const DROP_TYPE_INSIDE = 'inside';

interface GetMenuAfterInsertProps {
    menuData: Array<any>,
    dropdableItemData: any;
    toIndexes: Array<number>;
    dropType?: string;
}

const GetMenuAfterInsert = ({ menuData, dropdableItemData, toIndexes, dropType = DROP_TYPE_BEFORE }: GetMenuAfterInsertProps) => {
    const getUpdatedDataByIndexes = (data: Array<any>, level = 0): Array<any> => {
        if (!Array.isArray(toIndexes)) {
            return data;
        }
        if (toIndexes.length === 0 && dropdableItemData) {
            data.push(dropdableItemData);
            return data;
        }
        if (toIndexes.length && toIndexes[level] !== undefined) {
            let currentIndex = Number(toIndexes[level]);
            if (currentIndex < 0 && dropdableItemData) {
                if (data.length) {
                    data.unshift(dropdableItemData);
                } else {
                    data.push(dropdableItemData);
                }
                return data;
            }
            if (data[currentIndex] && dropdableItemData) {
                const currentItem: any = { ...data[currentIndex] };
                if (toIndexes.length === (level + 1)) {
                    if (dropType === DROP_TYPE_BEFORE) {
                        const beforeRemoveData = data.splice(0, currentIndex);
                        data = [
                            ...beforeRemoveData,
                            ...[{ ...dropdableItemData }],
                            ...data,
                        ];
                    } else if (dropType === DROP_TYPE_AFTER) {
                        const beforeRemoveData = data.splice(0, currentIndex + 1);
                        data = [
                            ...beforeRemoveData,
                            ...[{ ...dropdableItemData }],
                            ...data,
                        ];
                    } else if (dropType === DROP_TYPE_INSIDE) {
                        if (!currentItem.hasOwnProperty('children')) {
                            currentItem['children'] = [];
                        }
                        currentItem['children'].unshift(dropdableItemData);
                        data[currentIndex] = currentItem;
                    }
                } else if (currentItem.hasOwnProperty('children')) {
                    currentItem['children'] = getUpdatedDataByIndexes(currentItem['children'], level + 1);
                    data[currentIndex] = currentItem;
                }
            }
        }
        return data;
    }

    return getUpdatedDataByIndexes(menuData);
}

export default GetMenuAfterInsert;
