import {IContextMenu} from '../interfaces/components/IContextMenu';
import {IAppBus} from '../interfaces/bus/IAppBus';
import {IAppCommands} from '../interfaces/commands/IAppCommands';
import {TItem} from '../types/TItem';
import 'jquery';


export class ItemContextMenu implements IContextMenu {

    protected html:string = `
        <div class="context-menu">
            <div class="context-menu-item js-rename-button">
                Переименовать
            </div>
            <div class="context-menu-item js-delete-button">
                Удалить
            </div>
        </div>
    `;

    protected $template:JQuery;

    protected $renameButton:JQuery;

    protected $deleteButton:JQuery;

    protected appBus:IAppBus;

    protected appCommands:IAppCommands;

    protected itemData:TItem;

    public get template():JQuery
    {
        return this.$template;
    }

    public constructor()
    {
        this.$template = $(this.html);
        this.$renameButton = this.$template.find('.js-rename-button');
        this.$deleteButton = this.$template.find('.js-delete-button');
    }

    public setAppBus(bus:IAppBus)
    {
        this.appBus = bus;
    }

    public setAppCommands(commands:IAppCommands)
    {
        this.appCommands = commands;
    }

    public eventsListen()
    {
        this.$renameButton.on('click', ()=>{
            this.hide();
            setTimeout(()=>{
                this.appBus.execItemModal(this.itemData.name)
                    .then((newName:string)=>{
                        return this.appCommands.renameItem(this.itemData.id, newName);
                    })
                    .then((resp:any)=>{
                        if(resp.success){
                            this.appBus.renamedItem(resp.item);
                        }
                    });
            }, 200);
        });
        this.$deleteButton.on('click', ()=>{
            this.appCommands.deleteItem(this.itemData.id)
                .then((resp:any)=>{
                    if(resp.success){
                        this.appBus.deletedItem(this.itemData);
                    }
                });
        });
    }

    public show(x:number, y:number, itemData:TItem)
    {
        this.itemData = itemData;
        this.$template.css({top: y, left: x});
        this.$template.show();
    }

    public hide()
    {
        this.$template.hide();
    }

}