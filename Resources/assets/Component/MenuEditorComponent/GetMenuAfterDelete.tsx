/*
 * @copyright EveryWorkflow. All rights reserved.
 */

interface GetMenuAfterDeleteProps {
    menuData: Array<any>,
    fromIndexes: Array<number>;
}

const GetMenuAfterDelete = ({ menuData, fromIndexes }: GetMenuAfterDeleteProps) => {
    const generateDropableItemDataByIndexes = (data: Array<any>, level = 0): Array<any> => {
        if (Array.isArray(fromIndexes) && fromIndexes[level] !== undefined && data[fromIndexes[level]]) {
            const currentIndex = fromIndexes[level];
            const currentItem: any = { ...data[currentIndex] };
            if (currentItem.hasOwnProperty('children')) {
                currentItem['children'] = generateDropableItemDataByIndexes(currentItem['children'], level + 1);
            }
            data[currentIndex] = currentItem;
            if (fromIndexes.length === (level + 1)) {
                data.splice(currentIndex, 1);
            }
        }
        return data;
    }
    
    return generateDropableItemDataByIndexes(menuData);
}

export default GetMenuAfterDelete;
