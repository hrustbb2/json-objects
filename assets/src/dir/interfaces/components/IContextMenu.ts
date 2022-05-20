import {IAppBus} from '../bus/IAppBus';
import {IAppCommands} from '../commands/IAppCommands';
import {TDir} from '../../types/TDir';

export interface IContextMenu {
    template:JQuery;
    eventsListen():void;
    setAppBus(bus:IAppBus):void;
    setAppCommands(commands:IAppCommands):void;
    show(x:number, y:number, data:any):void;
    hide():void;
}