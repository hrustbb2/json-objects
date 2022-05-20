import {Factory as AdminPanelFactory} from '@common/admin/Factory';
import {Factory} from './Factory';
import {TSettings} from './types/TSettings';
import 'jquery';

declare let settings:TSettings;

$(()=>{
    let adminPanelFactory = new AdminPanelFactory();
    adminPanelFactory.initAdminPanel();
    let factory = new Factory();
    factory.init($('.js-app-container'));
    factory.getComponentsFactory().getAppContainer().renderObjForm(settings.item.object);
    // factory.getComponentsFactory().getObjectForm('obj-form-key').render(settings.item.object);
});