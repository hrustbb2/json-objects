export type TDir = {
    id:string;
    name:string;
    parent?:TDir;
    path?:TDir[];
}