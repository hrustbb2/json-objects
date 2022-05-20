import {IItem} from '../interfaces/components/IItem';
import {IAppBus} from '../interfaces/bus/IAppBus';
import * as types from '../types';
import 'bootstrap';

declare let settings:types.TSettings;

export class Item implements IItem {
    
    protected html:string = `
        <div class="dir">
            <div class="item-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-file-earmark" viewBox="0 0 16 16">
                    <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
                </svg>
            </div>
            <div class="item-name js-name">
            </div>
        </div>
    `;

    protected $template:JQuery;

    protected $name:JQuery;

    protected appBus:IAppBus;

    protected data:types.TItem;

    public constructor()
    {
        this.$template = $(this.html);
        this.$name = this.$template.find('.js-name');
    }

    public get template():JQuery
    {
        return this.$template;
    }

    public get id():string
    {
        return this.data.id;
    }

    public setAppBus(bus:IAppBus)
    {
        this.appBus = bus;
    }

    public eventsListen()
    {
        let options = {
            title: this.data.name,
        };
        (<any>this.$template).tooltip(options);
        this.template.on('click', ()=>{
            window.location.href = settings.itemUrl + '?item-id=' + this.data.id;
        });
        this.template.on('contextmenu', (e:JQuery.Event)=>{
            e.preventDefault();
            this.appBus.execItemContextMenu(e.pageX, e.pageY, this.data);
        });
    }

    public load(data:types.TDir)
    {
        this.data = data;
        this.$name.text(data.name);
    }

    public rename(name:string)
    {
        this.$name.text(name);
    }

}