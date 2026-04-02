import { Status } from "./Status";

export interface Comment {
    id: string;
    description: string;
    authorid: string;
    status: Status;
    postid: string;
    commentdate: string;
}
