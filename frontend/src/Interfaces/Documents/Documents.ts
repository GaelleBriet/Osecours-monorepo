export interface Document {
    id?: number;
    file_name: string;
    description?: string;
    size: number;
    url: string;
    date: Date | string;
    mimetype_id: number;
    doctype_id: number;
}