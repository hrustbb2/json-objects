import {IAppContainer} from '../interfaces/components/IAppContainer';
import {IDir} from '../interfaces/components/IDir';
import {IItem} from '../interfaces/components/IItem';
import {IToolsPanel} from '../interfaces/components/IToolsPanel';
import * as types from '../types';
import { Item } from './Item';

export class AppContainer implements IAppContainer {

    protected $container:JQuery;

    protected $itemsContainer:JQuery;

    protected toolsPanel:IToolsPanel;

    protected dirs:IDir[] = [];

    protected items:IItem[] = [];

    protected dirCreator:()=>IDir;

    protected itemCreator:()=>IItem;

    public setToolsPanel(toolsPanel:IToolsPanel)
    {
        this.toolsPanel = toolsPanel;
    }

    public init(container:JQuery)
    {
        this.$container = container;
        this.$itemsContainer = this.$container.find('.js-items-container');
        let toolsPanelContainer = this.$container.find('.js-tools-panel');
        this.toolsPanel.init(toolsPanelContainer);
        this.eventsListen();
    }

    protected eventsListen()
    {
        
    }

    public setDirCreator(callback:()=>IDir)
    {
        this.dirCreator = callback;
    }

    public setItemCreator(callback:()=>IItem)
    {
        this.itemCreator = callback;
    }

    public loadDirs(dirsData:types.TDirs)
    {
        for(let id in dirsData){
            let dir = this.dirCreator();
            dir.load(dirsData[id]);
            this.$itemsContainer.append(dir.template);
            dir.eventsListen();
            this.dirs.push(dir);
        }
    }

    public loadItems(itemsData:types.TItems)
    {
        for(let id in itemsData){
            let item = this.itemCreator();
            item.load(itemsData[id]);
            this.$itemsContainer.append(item.template);
            item.eventsListen();
            this.items.push(item);
        }
    }

    public appendDir(dirData:types.TDir)
    {
        let dir = this.dirCreator();
        dir.load(dirData);
        this.$itemsContainer.append(dir.template);
        dir.eventsListen();
        this.dirs.push(dir);
    }

    public appendItem(itemData:types.TItem)
    {
        let item = this.itemCreator();
        item.load(itemData);
        this.$itemsContainer.append(item.template);
        item.eventsListen();
        this.items.push(item);
    }

    public renameDir(dirData:types.TDir)
    {
        for(let dir of this.dirs){
            if(dir.id == dirData.id){
                dir.rename(dirData.name);
            }
        }
    }

    public renameItem(itemData:types.TItem)
    {
        for(let item of this.items){
            if(item.id == itemData.id){
                item.rename(itemData.name);
            }
        }
    }

    public deleteDir(dirData:types.TDir)
    {
        for(let i in this.dirs){
            if(this.dirs[i].id == dirData.id){
                this.dirs[i].template.remove();
                this.dirs.splice(+i, 1);
            }
        }
    }

    public deleteItem(itemData:types.TItem)
    {
        for(let i in this.items){
            if(this.items[i].id == itemData.id){
                this.items[i].template.remove();
                this.items.splice(+i, 1);
            }
        }
    }

}