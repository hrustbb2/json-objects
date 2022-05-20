import {IFactory as IAppFactory} from '../IFactory';
import {IAppBus} from './IAppBus';

export interface IFactory {
    setAppFactory(factory:IAppFactory):void;
    getAppBus():IAppBus;
}