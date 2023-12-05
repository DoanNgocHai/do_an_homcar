import { instance, getHeader } from "../instance";
const headers = getHeader();

export const listHistoryTransactionBuyer = async (): Promise<any> => {
  const { data } = await instance.get(
    "/transaction/history-transaction-buyer",
    headers
  );
  return data;
};

export const listHistoryTransactionSeller = async (): Promise<any> => {
  const { data } = await instance.get(
    "/transaction/history-transaction-seller",
    headers
  );
  return data;
};

export const confirmSale = async (idTran: any): Promise<any> => {
  const { data } = await instance.post(
    "/transaction/seller/confirm/" + idTran,
    {},
    headers
  );
  return data;
};

export const postBuyerApprove = async (idTran: any): Promise<any> => {
  const { data } = await instance.post(
    "/transaction/buyer/approve/" + idTran,
    {},
    headers
  );
  return data;
};

export const postBuyerRefuse = async (idTran: any): Promise<any> => {
  const { data } = await instance.post(
    "/transaction/buyer/refuse/" + idTran,
    {},
    headers
  );
  return data;
};

export const postSellerApprove = async (idTran: any): Promise<any> => {
  const { data } = await instance.post(
    "/transaction/seller/approve/" + idTran,
    {},
    headers
  );
  return data;
};

export const postSellerRefuse = async (idTran: any): Promise<any> => {
  const { data } = await instance.post(
    "/transaction/seller/refuse/" + idTran,
    {},
    headers
  );
  return data;
};

export const getHistorySaleCar = async () => {
  const { data } = await instance.get("/transaction/history/sale-car", headers);

  return data;
};

export const getHistoryBuyCar = async () => {
  const { data } = await instance.get("/transaction/history/buy-car", headers);

  return data;
};
