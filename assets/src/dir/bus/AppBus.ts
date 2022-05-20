import {IAppBus} from '../interfaces/bus/IAppBus';
import {TDir} from '../types/TDir';
import {TItem} from '../types/TItem';
import {IFactory as IComponentsFactory} from '../interfaces/components/IFactory';

export class AppBus implements IAppBus {

    protected componentsFactory:IComponentsFactory;

    public setComponentsFactory(factory:IComponentsFactory)
    {
        this.componentsFactory = factory;
    }

    public execDirContextMenu(x:number, y:number, dirData:TDir)
    {
        this.componentsFactory.getItemContextMenu().hide();
        let modal = this.componentsFactory.getDirContextMenu();
        modal.show(x, y, dirData);
    }

    public execItemContextMenu(x:number, y:number, itemData:TItem)
    {
        this.componentsFactory.getDirContextMenu().hide();
        let modal = this.componentsFactory.getItemContextMenu();
        modal.show(x, y, itemData);
    }

    public execDirModal(name:string = ''):Promise<string>
    {
        return new Promise<string>((resolve:any, reject:any)=>{
            let dirName = prompt('Имя папки', name);
            if(dirName){
                resolve(dirName);
            }else{
                reject();
            }
        });
    }

    public execItemModal(name:string = ''):Promise<string>
    {
        return new Promise<string>((resolve:any, reject:any)=>{
            let itemName = prompt('Имя объекта', name);
            if(itemName){
                resolve(itemName);
            }else{
                reject();
            }
        });
    }

    public newDir(dir:TDir)
    {
        this.componentsFactory.getAppContainer().appendDir(dir);
    }

    public newItem(item:TItem)
    {
        this.componentsFactory.getAppContainer().appendItem(item);
    }

    public renamedDir(dir:TDir)
    {
        this.componentsFactory.getAppContainer().renameDir(dir);
    }

    public renamedItem(item:TItem)
    {
        this.componentsFactory.getAppContainer().renameItem(item);
    }

    public deletedDir(dir:TDir)
    {
        this.componentsFactory.getAppContainer().deleteDir(dir);
    }

    public deletedItem(item:TItem)
    {
        this.componentsFactory.getAppContainer().deleteItem(item);
    }

}