import {TItem} from '../../types/TItem';
import {IAppBus} from '../bus/IAppBus';

export interface IItem {
    template:JQuery;
    id:string;
    setAppBus(bus:IAppBus):void;
    eventsListen():void;
    load(data:TItem):void;
    rename(name:string):void;
}