import {IFactory as IComponentsFactory} from './components/IFactory';
import {IFactory as ICommandsFactory} from './commands/IFactory';
import {IFactory as IObjectInputFactory} from '@common/object-input/interfaces/IFactory';

export interface IFactory {
    init(container:JQuery):void;
    getObjectInputFactory():IObjectInputFactory;
    getComponentsFactory():IComponentsFactory;
    getCommandsFactory():ICommandsFactory;
}