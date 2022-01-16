/*
 * @copyright EveryWorkflow. All rights reserved.
 */

export const DROP_TYPE_BEFORE = 'before'; //default
export const DROP_TYPE_AFTER = 'after';
export const DROP_TYPE_INSIDE = 'inside';

interface GetMenuAfterDropProps {
    menuData: Array<any>,
    fromIndexes: Array<number>;
    toIndexes: Array<number>;
    dropType?: string;
}

const GetMenuAfterDrop = ({ menuData, fromIndexes, toIndexes, dropType = DROP_TYPE_BEFORE }: GetMenuAfterDropProps) => {
    let dropdableItemData: any = undefined;
    const generateDropableItemDataByIndexes = (data: Array<any>, level = 0): Array<any> => {
        if (Array.isArray(fromIndexes) && fromIndexes[level] !== undefined && data[fromIndexes[level]]) {
            const currentIndex = fromIndexes[level];
            const currentItem: any = { ...data[currentIndex] };
            if (currentItem.hasOwnProperty('children')) {
                currentItem['children'] = generateDropableItemDataByIndexes(currentItem['children'], level + 1);
            }
            data[currentIndex] = currentItem;
            if (fromIndexes.length === (level + 1)) {
                dropdableItemData = { ...currentItem };
                data.splice(currentIndex, 1);
            }
        }
        return data;
    }

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
            if (fromIndexes.length === (level + 1) && fromIndexes[level] <= toIndexes[level] &&
                toIndexes.slice(0, level).join('-') === fromIndexes.slice(0, level).join('-')) {
                currentIndex = currentIndex - 1;
            }
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

    let updatedData: Array<any> = generateDropableItemDataByIndexes(menuData);
    updatedData = getUpdatedDataByIndexes(updatedData);
    return updatedData;
}

export default GetMenuAfterDrop;
