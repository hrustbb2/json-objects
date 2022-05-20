import {IFactory} from './interfaces/IFactory';
import {IFactory as IComponentsFactory} from './interfaces/components/IFactory';
import {Factory as ComponentsFactory} from './components/Factory';
import {IFactory as ICommandsFactory} from './interfaces/commands/IFactory';
import {Factory as CommandsFactory} from './commands/Factory';
import {IFactory as IObjectInputFactory} from '@common/object-input/interfaces/IFactory';
import {Factory as ObjectInputFactory} from '@common/object-input/Factory';

export class Factory implements IFactory {
    
    protected componentsFactory:IComponentsFactory = null;

    protected commandsFactory:ICommandsFactory = null;

    protected objectInputFactory:IObjectInputFactory;

    public init(container:JQuery)
    {
        this.objectInputFactory = new ObjectInputFactory();
        this.getComponentsFactory().init(container);
    }

    public getObjectInputFactory():IObjectInputFactory
    {
        return this.objectInputFactory;
    }
    
    public getComponentsFactory():IComponentsFactory
    {
        if(this.componentsFactory === null){
            this.componentsFactory = new ComponentsFactory();
            this.componentsFactory.setAppFactory(this);
        }
        return this.componentsFactory;
    }

    public getCommandsFactory():ICommandsFactory
    {
        if(this.commandsFactory === null){
            this.commandsFactory = new CommandsFactory();
            this.commandsFactory.setAppFactory(this);
        }
        return this.commandsFactory;
    }

}