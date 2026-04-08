import { Status } from "./Status";

export interface Comment {
    id: string;
    description: string;
    authorid: string;
    status: Status;
    postId: string;
    commentDate: string;
}
