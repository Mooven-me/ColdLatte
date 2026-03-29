import createClient from 'openapi-fetch';
import type { paths } from '../api-types';

export const apiClient = createClient<paths>({
   baseUrl: "/",
   credentials: "include"
});

export const formatNumber = (number: number) => {
  return Intl.NumberFormat('en-US', {
    notation: "compact",
    maximumFractionDigits: 1
  }).format(number);
}

export const truncate = (str: string, length: number) => {
  return str?.length > length ? str.substring(0, length) + "..." : str;
};