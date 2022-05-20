import {IDir} from './IDir';
import {IItem} from './IItem';
import {IToolsPanel} from './IToolsPanel';
import * as types from '../../types';

export interface IAppContainer {
    setToolsPanel(toolsPanel:IToolsPanel):void;
    init(container:JQuery):void;
    setDirCreator(callback:()=>IDir):void;
    setItemCreator(callback:()=>IItem):void;
    loadDirs(dirsData:types.TDirs):void;
    loadItems(itemsData:types.TItems):void;
    appendDir(dirData:types.TDir):void;
    appendItem(itemData:types.TItem):void;
    renameDir(dirData:types.TDir):void;
    renameItem(itemData:types.TItem):void;
    deleteDir(dirData:types.TDir):void;
    deleteItem(itemData:types.TItem):void;
}