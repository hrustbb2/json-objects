import {IAppBus} from '../bus/IAppBus';
import {IAppCommands} from '../commands/IAppCommands';

export interface IToolsPanel {
    setAppBus(bus:IAppBus):void;
    setAppCommands(commands:IAppCommands):void;
    init(container:JQuery):void;
}