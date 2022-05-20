import {IDir} from '../interfaces/components/IDir';
import {IAppBus} from '../interfaces/bus/IAppBus';
import * as types from '../types';
import 'bootstrap';

declare let settings:types.TSettings;

export class Dir implements IDir {

    protected html:string = `
        <div class="dir">
            <div class="item-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-folder" viewBox="0 0 16 16">
                    <path d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31zM2.19 4a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 4H2.19zm4.69-1.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707z"/>
                </svg>
            </div>
            <div class="item-name js-name">
            </div>
        </div>
    `;

    protected $template:JQuery;

    protected $name:JQuery;

    protected appBus:IAppBus;

    protected data:types.TDir;

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
            window.location.href = settings.url + '?dir-id=' + this.data.id;
        });
        this.template.on('contextmenu', (e:JQuery.Event)=>{
            e.preventDefault();
            this.appBus.execDirContextMenu(e.pageX, e.pageY, this.data);
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