import { instance, getHeader } from "../instance";

const headers = getHeader();

export type CreateCarDto = {
  title: string;
  brand_id: string;
  figure_id: string;
  year: string;
  odo: string;
  gear_id: string;
  color_id: string;
  seat: string;
  engine: string;
  price: number;
  description: string;
  thumbnail: string;

};

export type CreateCarResponse = {
    title: string;
    brand_id: string;
    figure_id: string;
    year: string;
    odo: string;
    gear_id: string;
    color_id: string;
    seat: string;
    engine: string;
    price: number;
    description: string;
    user_id: string;
    slug: string;
    id: string
};

export const userSaleCar = async (
  createCarDto: CreateCarDto
): Promise<CreateCarResponse> => {
  const { data } = await instance.post("/user/cars", createCarDto, headers);
  return data as CreateCarResponse;
};

export const listCar = async (page: number = 1): Promise<any> => {
  if (page != 1) {
    const { data } = await instance.get("/anonymous/list_cars?page="+page);
    return data;
  }
  const { data } = await instance.get("/anonymous/list_cars");
  return data;
};

export const getCarInfo = async (carId: any): Promise<any> => {
  const { data } = await instance.get("/anonymous/info_cars?id=" + carId);
  return data;
};

export const updateCar = async (
  carId: any,
  updateCarDto: any,
): Promise<any> => {
  const { data } = await instance.patch("/user/cars/" + carId , updateCarDto, headers);
  return data;
};

export const historySale = async (): Promise<any> => {
  const { data } = await instance.get("/user/history-sale", headers);
  return data;
};

export const deleteCar = async (carId: any): Promise<any> => {
  const { data } = await instance.delete("/user/cars/" + carId, headers);
  return data;
};

export const buyCarByCarId = async (carId: number): Promise<any> => {
  console.log(carId);
  
  const { data } = await instance.post(
    "/transaction/rest",
    {
      car_id: carId,
    },
    headers
  );

  return data;
};
