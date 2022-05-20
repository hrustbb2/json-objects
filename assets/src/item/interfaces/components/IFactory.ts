import {IFactory as IAppFactory} from '../IFactory';
import {IAppContainer} from '../components/IAppContainer';
import {IObjectForm} from '@common/object-input/interfaces/components/IObjectForm';

export interface IFactory {
    setAppFactory(factory:IAppFactory):void;
    getAppContainer():IAppContainer;
    init(container:JQuery):void;
    getObjectForm(key:string):IObjectForm;
}