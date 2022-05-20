import {IFactory as IAppFactory} from '../IFactory';
import {IAppContainer} from './IAppContainer';
import {IDir} from './IDir';
import {IItem} from './IItem';
import {IContextMenu} from './IContextMenu';

export interface IFactory {
    init(appContainer:JQuery):void;
    setAppFactory(factory:IAppFactory):void;
    getAppContainer():IAppContainer;
    createDir():IDir;
    createItem():IItem;
    getDirContextMenu():IContextMenu;
    getItemContextMenu():IContextMenu;
}