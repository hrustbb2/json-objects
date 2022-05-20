import {IFactory} from './interfaces/IFactory';
import {IFactory as IComponentsFactory} from './interfaces/components/IFactory';
import {Factory as ComponentsFactory} from './components/Factory';
import {IFactory as IBusFactory} from './interfaces/bus/IFactory';
import {Factory as BusFactory} from './bus/Factory';
import {IFactory as ICommandsFactory} from './interfaces/commands/IFactory';
import {Factory as CommandsFactory} from './commands/Factory';

export class Factory implements IFactory {

    protected componentsFactory:IComponentsFactory = null;

    protected busFactory:IBusFactory = null;

    protected commandsFactory:ICommandsFactory = null;

    public init(appContainer:JQuery)
    {
        let componentsFactory = this.getComponentsFactory();
        componentsFactory.init(appContainer);
        $('body').on('click', ()=>{
            this.getComponentsFactory().getDirContextMenu().hide();
            this.getComponentsFactory().getItemContextMenu().hide();
        });
    }

    public getComponentsFactory():IComponentsFactory
    {
        if(this.componentsFactory === null){
            this.componentsFactory = new ComponentsFactory();
            this.componentsFactory.setAppFactory(this);
        }
        return this.componentsFactory;
    }

    public getBusFactory():IBusFactory
    {
        if(this.busFactory === null){
            this.busFactory = new BusFactory();
            this.busFactory.setAppFactory(this);
        }
        return this.busFactory;
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