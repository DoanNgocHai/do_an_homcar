import { instanceUpload } from "../instance";



export type UploadFileResponse = {
    path: string;
    url: string;
};
export const uploadFile = async (file:any
): Promise<UploadFileResponse> => {
  const { data } = await instanceUpload.post("/upload-file", file);
  return data as UploadFileResponse;
};