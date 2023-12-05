import { instance, getHeader } from "../instance";

const headers = getHeader();


export const listUser = async (): Promise<any> => {
  const { data } = await instance.get("/admin/user", headers);
  return data;
};

export const listCar = async (): Promise<any> => {
  const { data } = await instance.get("/admin/car", headers);
  return data;
};


export const adminVerify = async (idCar: any): Promise<any> => {
    const { data } = await instance.post("/admin/verify/" + idCar,{}, headers);
    return data;
};