import {IToolsPanel} from '../interfaces/components/IToolsPanel';
import {IAppBus} from '../interfaces/bus/IAppBus';
import {IAppCommands} from '../interfaces/commands/IAppCommands';
import * as types from '../types';

declare let settings:types.TSettings;

export class ToolsPanel implements IToolsPanel {

    protected $container:JQuery;

    protected appBus:IAppBus;

    protected appCommands:IAppCommands;

    protected $addDirButton:JQuery;

    protected $addItemButton:JQuery;

    protected $itemDropDown:JQuery;

    protected $deleteButton:JQuery;

    public setAppBus(bus:IAppBus)
    {
        this.appBus = bus;
    }

    public setAppCommands(commands:IAppCommands)
    {
        this.appCommands = commands;
    }

    public init(container:JQuery)
    {
        this.$container = container;
        this.$addDirButton = this.$container.find('.js-add-button');
        this.$addItemButton = this.$container.find('.js-add-item-button');
        this.$itemDropDown = this.$container.find('.js-items-dropdown');
        this.$deleteButton = this.$container.find('.js-delete-button');
        this.eventsListen();
    }

    protected eventsListen()
    {
        this.$addDirButton.on('click', ()=>{
            this.appBus.execDirModal()
                .then((name:string)=>{
                    return this.appCommands.newDir(settings.currentId, name);
                })
                .then((resp:any)=>{
                    if(resp.success){
                        this.appBus.newDir(resp.dir);
                    }
                });
        });
        this.$addItemButton.on('click', ()=>{
            this.$itemDropDown.toggleClass('show');
        });
        this.$itemDropDown.find('.js-dropdown-item').each((index:number, el:HTMLElement)=>{
            let type = $(el).attr('item');
            $(el).on('click', ()=>{
                this.appBus.execItemModal()
                    .then((name:string)=>{
                        this.$itemDropDown.removeClass('show');
                        return this.appCommands.newItem(settings.currentId, type, name);
                    }, ()=>{
                        this.$itemDropDown.removeClass('show');
                    })
                    .then((resp:any)=>{
                        if(resp && resp.success){
                            this.appBus.newItem(resp.item);
                        }
                    });
            });
        });
    }

}