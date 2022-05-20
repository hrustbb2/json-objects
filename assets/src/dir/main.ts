import {Factory as AdminPanelFactory} from '@common/admin/Factory';
import {Factory} from './Factory';
import {TSettings} from './types/TSettings';
import 'jquery';

declare let settings:TSettings;

$(()=>{
    let adminPanelFactory = new AdminPanelFactory();
    adminPanelFactory.initAdminPanel();
    let factory = new Factory();
    factory.init($('.js-dir-app-container'));
    factory.getComponentsFactory().getAppContainer().loadDirs(settings.dirs);
    factory.getComponentsFactory().getAppContainer().loadItems(settings.items);
});