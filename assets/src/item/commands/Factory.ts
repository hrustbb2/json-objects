import {IFactory} from '../interfaces/commands/IFactory';
import {IFactory as IAppFactory} from '../interfaces/IFactory';
import {IAppCommands} from '../interfaces/commands/IAppCommands';
import {AppCommands} from './AppCommands';

export class Factory implements IFactory {

    protected appFactory:IAppFactory;

    protected appCommands:IAppCommands = null;

    public setAppFactory(factory:IAppFactory)
    {
        this.appFactory = factory;
    }

    public getAppCommands():IAppCommands
    {
        if(this.appCommands === null){
            this.appCommands = new AppCommands();
        }
        return this.appCommands;
    }

}