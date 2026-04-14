import { Status } from "./Status";

export interface Post {
    id: string;
    subject: string;
    description: string;
    publishDate: string | null;
    status: Status;
    authorId: string;
    numComments: number;
    authorName: string;
}
