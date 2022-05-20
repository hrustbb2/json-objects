import {IFactory} from '../interfaces/components/IFactory';
import {IFactory as IAppFactory} from '../interfaces/IFactory';
import {IObjectForm} from '@common/object-input/interfaces/components/IObjectForm';
import {IAppContainer} from '../interfaces/components/IAppContainer';
import {AppContainer} from './AppContainer';

type TObjectForms = {
    [key:string]:IObjectForm;
}

export class Factory implements IFactory {
    
    protected appFactory:IAppFactory;

    protected appContainer:IAppContainer = null;

    protected objectForms:TObjectForms = {};

    public setAppFactory(factory:IAppFactory)
    {
        this.appFactory = factory;
    }

    public getAppContainer():IAppContainer
    {
        return this.appContainer;
    }

    public init(container:JQuery)
    {
        this.appContainer = new AppContainer();
        this.appContainer.setCompositeCreator(()=>{
            return this.appFactory.getObjectInputFactory().getComponentsFactory().createComposite();
        });
        let appCommands = this.appFactory.getCommandsFactory().getAppCommands();
        this.appContainer.setAppCommands(appCommands);
        let objectBus = this.appFactory.getObjectInputFactory().getBusFactory().getObjectBus();
        this.appContainer.setObjectBus(objectBus);
        let objForm = this.appFactory.getObjectInputFactory().getComponentsFactory().getObjectForm('obj-form-key');
        this.appContainer.setObjectForm(objForm);
        this.appContainer.init(container);
    }

    public getObjectForm(key:string):IObjectForm
    {
        return this.appFactory.getObjectInputFactory().getComponentsFactory().getObjectForm(key);
    }

}