import { instance, getHeader } from "../instance";

const headers = getHeader();
export type ProfileUser = {
    id: number;
    name: string;
    email: string;
    avatar: string;
    date_of_birth: string;
    address: string;
    phone: string;
    post_count: string;
    role: string;
};
  
export const getProfile = async (): Promise<any> => {

    try {
      const response = await instance.get("/profile", headers);
      const data: ProfileUser[] = response.data;
      console.log(123);
      
      return data ;
    } catch (error) {
      // Xử lý lỗi một cách thích hợp
      throw new Error(`Không thể lấy dữ liệu`);

    }
};

  
export const updateProfile = async (
    updateProfileDto: any
): Promise<any> => {
    const { data } = await instance.put("/profile", updateProfileDto, headers);
    return data;
};