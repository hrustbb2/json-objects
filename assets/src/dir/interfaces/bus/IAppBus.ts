import {IFactory as IComponentsFactory} from '../components/IFactory';
import {TDir} from '../../types/TDir';
import {TItem} from '../../types/TItem';

export interface IAppBus {
    setComponentsFactory(factory:IComponentsFactory):void;
    execDirContextMenu(x:number, y:number, dirData:TDir):void;
    execItemContextMenu(x:number, y:number, itemData:TItem):void;
    execDirModal(name?:string):Promise<string>
    execItemModal(name?:string):Promise<string>
    newDir(dir:TDir):void;
    newItem(item:TItem):void;
    renamedDir(dir:TDir):void;
    renamedItem(item:TItem):void;
    deletedDir(dir:TDir):void;
    deletedItem(item:TItem):void;
}