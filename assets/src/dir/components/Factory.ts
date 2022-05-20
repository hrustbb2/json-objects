import {IFactory} from '../interfaces/components/IFactory';
import {IFactory as IAppFactory} from '../interfaces/IFactory';
import {IAppContainer} from '../interfaces/components/IAppContainer';
import {AppContainer} from '../components/AppContainer';
import {IDir} from '../interfaces/components/IDir';
import {Dir} from '../components/Dir';
import {IItem} from '../interfaces/components/IItem';
import {Item} from '../components/Item';
import {IContextMenu} from '../interfaces/components/IContextMenu';
import {DirContextMenu} from '../components/DirContextMenu';
import {ItemContextMenu} from '../components/ItemContextMenu';
import {IToolsPanel} from '../interfaces/components/IToolsPanel';
import {ToolsPanel} from '../components/ToolsPanel';

export class Factory implements IFactory {

    protected appFactory:IAppFactory;

    protected appContainer:IAppContainer = null;

    protected dirContextMenu:IContextMenu = null;

    protected itemContextMenu:IContextMenu = null;

    public setAppFactory(factory:IAppFactory)
    {
        this.appFactory = factory;
    }

    public init(appContainer:JQuery)
    {
        this.appContainer = new AppContainer();
        this.appContainer.setDirCreator(()=>{
            return this.createDir();
        });
        this.appContainer.setItemCreator(()=>{
            return this.createItem();
        });
        let toolsPanel = this.createToolsPanel();
        this.appContainer.setToolsPanel(toolsPanel);
        this.appContainer.init(appContainer);
    }

    public getAppContainer():IAppContainer
    {
        return this.appContainer;
    }

    public createDir():IDir
    {
        let dir = new Dir();
        let appBus = this.appFactory.getBusFactory().getAppBus();
        dir.setAppBus(appBus);
        return dir;
    }

    public createItem():IItem
    {
        let item = new Item();
        let appBus = this.appFactory.getBusFactory().getAppBus();
        item.setAppBus(appBus);
        return item;
    }

    protected createToolsPanel():IToolsPanel
    {
        let toolsPaenel = new ToolsPanel();
        let appBus = this.appFactory.getBusFactory().getAppBus();
        toolsPaenel.setAppBus(appBus);
        let appCommands = this.appFactory.getCommandsFactory().getAppCommands();
        toolsPaenel.setAppCommands(appCommands);
        return toolsPaenel;
    }

    public getDirContextMenu():IContextMenu
    {
        if(this.dirContextMenu === null){
            this.dirContextMenu = new DirContextMenu();
            let appBus = this.appFactory.getBusFactory().getAppBus();
            this.dirContextMenu.setAppBus(appBus);
            let appCommands = this.appFactory.getCommandsFactory().getAppCommands();
            this.dirContextMenu.setAppCommands(appCommands);
            $('body').append(this.dirContextMenu.template);
            this.dirContextMenu.eventsListen();
        }
        return this.dirContextMenu;
    }

    public getItemContextMenu():IContextMenu
    {
        if(this.itemContextMenu === null){
            this.itemContextMenu = new ItemContextMenu();
            let appBus = this.appFactory.getBusFactory().getAppBus();
            this.itemContextMenu.setAppBus(appBus);
            let appCommands = this.appFactory.getCommandsFactory().getAppCommands();
            this.itemContextMenu.setAppCommands(appCommands);
            $('body').append(this.itemContextMenu.template);
            this.itemContextMenu.eventsListen();
        }
        return this.itemContextMenu;
    }

}