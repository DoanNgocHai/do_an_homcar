import { instance, getHeader } from "../instance";

const headers = getHeader();

export type SaveFavoritesDto = {
  car_id: string;
};


export const saveCarFavorites = async (
    saveFavoritesDto: SaveFavoritesDto
): Promise<any> => {
  const { data } = await instance.post("/user/favorites", saveFavoritesDto, headers);
  return data;
};

export const listCarFavorites = async (): Promise<any> => {
  const { data } = await instance.get("/user/favorites", headers);
  return data;
};


export const deleteCarFavorites = async (favId: any): Promise<any> => {
  const { data } = await instance.delete("/user/favorites/" + favId, headers);
  return data;
};
  