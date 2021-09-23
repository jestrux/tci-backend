// import axios from 'axios';

const BASE_URL = process.env.VUE_APP_BASE_URL || '';

export const mock = (returnError = false) => {
  return new Promise((resolve, reject) => {
    setTimeout(() => {
      if(returnError)
        reject();
      else
        resolve({success: true});
    }, 2000)
  })
};

export const get = async (url, token = 'null') => {
  return await request('get', url, token);
};

export const patch = async (url, data, token = 'null') => {
  return await request('patch', url, token, data);
};

export const remove = async (url, token = 'null') => {
  return await request('delete', url, token);
};

export const post = async (url, data, token = 'null') => {
  return await request('post', url, token, data);
};

export const request = async (type, endpoint, token, data) => {
  const response = await axios({
    method: type,
    url: BASE_URL + endpoint,
    headers: {
      "Content-Type": "application/json",
      'Authorization': token
    },
    data
  });

  return response.data;
};