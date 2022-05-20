import {IAppCommands} from '../interfaces/commands/IAppCommands';
import {TSettings} from '../types/TSettings';

declare let settings:TSettings;

export class AppCommands implements IAppCommands {

    public editObject(key:string, formData:FormData):Promise<any>
    {
        return new Promise<any>((resolve:any, reject:any)=>{
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            formData.append('id', settings.item.id);
            formData.append('key', key);

            $.ajax({
                url: settings.editObjUrl,
                data: formData,
                type: 'POST',
                dataType: 'json',
                processData : false,
                contentType : false,
                success: (resp:any) => {
                    resolve(resp);
                },
                error: (e:JQueryXHR) => {
                    reject(e.responseJSON);
                }
            });
        });
    }

}