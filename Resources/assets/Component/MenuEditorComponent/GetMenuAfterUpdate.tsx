/*
 * @copyright EveryWorkflow. All rights reserved.
 */

interface GetMenuAfterUpdateProps {
    menuData: Array<any>,
    dropdableItemData: any;
    toIndexes: Array<number>;
}

const GetMenuAfterUpdate = ({ menuData, dropdableItemData, toIndexes }: GetMenuAfterUpdateProps) => {
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
            if (data[currentIndex] && dropdableItemData) {
                const currentItem: any = { ...data[currentIndex] };
                if (toIndexes.length === (level + 1)) {
                    const beforeRemoveData = data.splice(0, currentIndex);
                    data.shift();
                    dropdableItemData['children'] = currentItem['children'];
                    data = [
                        ...beforeRemoveData,
                        ...[{ ...dropdableItemData }],
                        ...data,
                    ];
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

export default GetMenuAfterUpdate;
