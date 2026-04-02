import { Status } from "./Status";

export interface Post {
    id: string;
    subject: string;
    description: string;
    publishdate: string;
    status: Status;
    authorid: string;
    numcomments: number;
}
