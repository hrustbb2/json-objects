import {IFactory as IAppFactory} from '../IFactory';
import {IAppCommands} from '../commands/IAppCommands';

export interface IFactory {
    setAppFactory(factory:IAppFactory):void;
    getAppCommands():IAppCommands;
}