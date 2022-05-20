import {IFactory} from '../interfaces/bus/IFactory';
import {IFactory as IAppFactory} from '../interfaces/IFactory';
import {AppBus} from './AppBus';
import {IAppBus} from '../interfaces/bus/IAppBus';

export class Factory implements IFactory {

    protected appFactory:IAppFactory;

    protected appBus:IAppBus = null;

    public setAppFactory(factory:IAppFactory)
    {
        this.appFactory = factory;
    }

    public getAppBus():IAppBus
    {
        if(this.appBus === null){
            this.appBus = new AppBus();
            let componentsFactor = this.appFactory.getComponentsFactory();
            this.appBus.setComponentsFactory(componentsFactor);
        }
        return this.appBus;
    }

}