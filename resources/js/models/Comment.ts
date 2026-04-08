import { Status } from "./Status";

export interface Comment {
    id: string;
    description: string;
    authorId: string;
    status: Status;
    postId: string;
    commentDate: string;
}
