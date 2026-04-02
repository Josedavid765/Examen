import { Status } from "./Status";

export interface Post {
    id: string;
    subject: string;
    description: string;
    publishDate: string;
    status: Status;
    authorId: string;
    numComments: number;
}
