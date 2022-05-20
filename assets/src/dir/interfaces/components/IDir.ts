import {TDir} from '../../types/TDir';
import {IAppBus} from '../bus/IAppBus';

export interface IDir {
    template:JQuery;
    id:string;
    setAppBus(bus:IAppBus):void;
    eventsListen():void;
    load(data:TDir):void;
    rename(name:string):void;
}