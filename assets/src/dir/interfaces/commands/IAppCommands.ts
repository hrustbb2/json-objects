export interface IAppCommands {
    newDir(parentDir:string, name:string):Promise<any>;
    newItem(dirId:string, type:string, name:string):Promise<any>;
    renameDir(dirId:string, name:string):Promise<any>;
    renameItem(itemId:string, name:string):Promise<any>;
    deleteDir(dirId:string):Promise<any>;
    deleteItem(itemId:string):Promise<any>;
}