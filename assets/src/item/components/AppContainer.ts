import {IAppContainer} from '../interfaces/components/IAppContainer';
import {IAppCommands} from '../interfaces/commands/IAppCommands';
import {TErrors} from '@common/object-input/types/TErrors';
import {IObjectForm} from '@common/object-input/interfaces/components/IObjectForm';
import {IObjectBus} from '@common/object-input/interfaces/bus/IObjectBus';
import {IComposite} from '@common/object-input/interfaces/components/IComposite';
import {TComposite} from '@common/object-input/types';
import {TSettings} from '../types/TSettings';

declare let settings:TSettings;

export class AppContainer implements IAppContainer {

    protected $container:JQuery;

    protected $keyInput:JQuery;

    protected $keyError:JQuery;

    protected objectForm:IObjectForm;

    protected $submitButton:JQuery;

    protected appCommands:IAppCommands;

    protected objectBus:IObjectBus;

    protected compositeCreator:()=>IComposite;

    public setCompositeCreator(callback:()=>IComposite)
    {
        this.compositeCreator = callback;
    }

    public setAppCommands(commands:IAppCommands)
    {
        this.appCommands = commands;
    }

    public setObjectBus(bus:IObjectBus)
    {
        this.objectBus = bus;
    }

    public setObjectForm(form:IObjectForm)
    {
        this.objectForm = form;
    }

    public init(container:JQuery)
    {
        this.$container = container;
        this.$keyInput = this.$container.find('.js-key-input');
        this.$keyError = this.$container.find('.js-key-error-message');
        let $objectForm = this.$container.find('.js-object-form-container');
        this.objectForm.init($objectForm);
        this.$submitButton = this.$container.find('.js-submit-button');
        
        this.$keyInput.val(settings.item.key);
        this.eventsListen();
    }

    protected eventsListen()
    {
        this.$submitButton.on('click', (e:Event)=>{
            e.preventDefault();
            let key = <string>this.$keyInput.val();
            this.appCommands.editObject(key, this.objectForm.getFormData())
                .then((resp:any)=>{
                    if(resp.success){
                        window.location.href = settings.successUrl;
                    }
                })
                .catch((resp:any)=>{
                    this.showErrors(resp.errors);
                    this.objectForm.setData(resp.item.object);
                    this.objectForm.rerender();
                });
        })
    };

    protected showErrors(errors:TErrors)
    {
        if(errors['key']){
            this.$keyError.text(errors['key'][0]);
            this.$keyError.addClass('is-invalid');
        }
    }

    public renderObjForm(data:TComposite)
    {
        this.objectForm.render(data);
    }

}